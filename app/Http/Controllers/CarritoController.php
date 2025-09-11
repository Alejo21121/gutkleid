<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\FacturaVenta;
use App\Models\DetalleFacturaV;
use App\Models\MetodoPago;
use Illuminate\Support\Facades\DB;
use App\Models\Imagen;
use App\Models\Talla;
use App\Models\Persona;
use Illuminate\Support\Facades\Mail;
use App\Mail\FacturaMail;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Config;

class CarritoController extends Controller
{
    public function index()
    {
        $carrito = session()->get('carrito', []);
        return view('carrito', compact('carrito'));
    }

    public function finalizar()
    {
        $carrito = session()->get('carrito', []);

        if (empty($carrito)) {
            return redirect()->route('carrito.index')->with('error', 'El carrito está vacío.');
        }

        try {
            DB::beginTransaction();

            $factura = new FacturaVenta();
            $factura->fecha_venta = now();
            $factura->nit_tienda = '123456789';
            $factura->dire_tienda = 'Calle Ficticia #123';
            $factura->telef_tienda = '3001234567';
            $factura->id_persona = session('usuario')['id_persona'] ?? 1;
            $factura->id_metodo_pago = MetodoPago::first()->id_metodo_pago ?? 1;
            $factura->total = 0;
            $factura->envio = 0;
            $factura->save();

            $totalFactura = 0;

            foreach ($carrito as $item) {
                $producto = Producto::find($item['id_producto']);
                if (!$producto) {
                    DB::rollBack();
                    return redirect()->route('carrito.index')->with('error', 'Producto no encontrado.');
                }

                $tallaBuscada = strtoupper(trim($item['talla'] ?? ''));
                if (empty($tallaBuscada)) {
                    DB::rollBack();
                    return redirect()->route('carrito.index')->with('error', 'Debe seleccionar una talla para ' . $producto->nombre);
                }

                $tallaProducto = Talla::where('id_producto', $producto->id_producto)
                    ->where('talla', $tallaBuscada)
                    ->first();

                if (!$tallaProducto || $tallaProducto->cantidad < $item['cantidad']) {
                    DB::rollBack();
                    return redirect()->route('carrito.index')->with('error', 'Stock insuficiente para ' . $producto->nombre . ' talla ' . $tallaBuscada);
                }

                $cantidad = $item['cantidad'];
                $valorUnitario = $item['valor'] ?? 0; // <-- prevenir undefined key
                $totalItem = $valorUnitario * $cantidad;

                $detalle = new DetalleFacturaV();
                $detalle->id_factura_venta = $factura->id_factura_venta;
                $detalle->id_producto = $producto->id_producto;
                $detalle->id_talla = $tallaProducto->id;
                $detalle->cantidad = $cantidad;
                $detalle->subtotal = $totalItem;
                $detalle->iva = $totalItem * 0.19;
                $detalle->save();

                // Restar stock
                $tallaProducto->cantidad -= $cantidad;
                $tallaProducto->save();

                $totalFactura += $totalItem * 1.19; // ya incluye IVA
            }

            // Envío
            $costoEnvio = $totalFactura >= 150000 ? 0 : 15000;
            $factura->envio = $costoEnvio;
            $factura->total = $totalFactura + $costoEnvio;
            $factura->save();

            DB::commit();

            // Cargar relaciones para la vista del PDF
            $factura->load(['detalles.producto', 'cliente', 'detalles.talla']);

            // Generar PDF
            $logoPath = public_path('IMG/LOGO3.png');
            $logoType = pathinfo($logoPath, PATHINFO_EXTENSION);
            $logoData = file_get_contents($logoPath);
            $base64Logo = 'data:image/' . $logoType . ';base64,' . base64_encode($logoData);

            $pdf = Pdf::loadView('factura_pdf', [
                'factura' => $factura,
                'logo' => $base64Logo
            ]);

            $nombreArchivo = 'Factura_GutKleid_' . $factura->id_factura_venta . '.pdf';
            $rutaArchivo = public_path('facturas/' . $nombreArchivo);
            if (!file_exists(public_path('facturas'))) {
                mkdir(public_path('facturas'), 0777, true);
            }
            $pdf->save($rutaArchivo);
            $factura->factura_pdf = 'facturas/' . $nombreArchivo;
            $factura->save();

            // Enviar correo
            $cliente = $factura->cliente;
            if ($cliente && $cliente->correo) {
                Mail::to($cliente->correo)->send(new FacturaMail($factura, $rutaArchivo));
            }

            session()->forget('carrito');

            return redirect()->route('carrito.index')
                ->with('success', '¡Compra realizada con éxito! La factura ha sido enviada a tu correo.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('carrito.index')->with('error', 'Error al finalizar la compra: ' . $e->getMessage());
        }
    }

    public function agregar(Request $request)
    {
        $id_producto = $request->input('id_producto');
        $nombre = $request->input('nombre');
        $valor = $request->input('precio');
        $talla = strtoupper(trim($request->input('talla')));
        $color = $request->input('color') ?? 'N/A';
        $cantidad = max((int) $request->input('cantidad', 1), 1);

        if (empty($talla)) {
            return redirect()->route('carrito.index')->with('error', 'Debe seleccionar una talla para continuar.');
        }

        $producto = Producto::with('imagenes')->findOrFail($id_producto);
        $rutaImagen = $producto->imagenes->first()->ruta ?? 'IMG/default.jpg';
        $rutaCompleta = 'IMG/imagenes_demo/' . basename($rutaImagen);

        $carrito = session()->get('carrito', []);
        $clave = $id_producto . '-' . $talla . '-' . $color;

        if (isset($carrito[$clave])) {
            $carrito[$clave]['cantidad'] += $cantidad;
        } else {
            $carrito[$clave] = [
                "id_producto" => $id_producto,
                "nombre" => $nombre,
                "valor" => $valor,
                "talla" => $talla,
                "color" => $color,
                "cantidad" => $cantidad,
                "imagen" => $rutaCompleta
            ];
        }

        session()->put('carrito', $carrito);

        return redirect()->route('carrito.index')->with('success', 'Producto agregado al carrito.');
    }

    public function actualizarCantidad(Request $request, $clave)
    {
        $carrito = session()->get('carrito', []);
        if (isset($carrito[$clave])) {
            $tipo = $request->input('tipo');
            if ($tipo === 'sumar') $carrito[$clave]['cantidad'] += 1;
            elseif ($tipo === 'restar' && $carrito[$clave]['cantidad'] > 1) $carrito[$clave]['cantidad'] -= 1;
            session()->put('carrito', $carrito);
        }
        return redirect()->route('carrito.index');
    }

    public function eliminar($clave)
    {
        $carrito = session()->get('carrito', []);
        if (isset($carrito[$clave])) {
            unset($carrito[$clave]);
            session()->put('carrito', $carrito);
        }
        return redirect()->back()->with('success', 'Producto eliminado del carrito.');
    }

    public function vaciar()
    {
        session()->forget('carrito');
        return redirect()->back()->with('success', 'Carrito vaciado.');
    }
public function checkout()
{
    $orderId = uniqid(); // O tu ID de factura
    $total = \Cart::getTotal(); // O como tengas tu total del carrito

    $apiSecret = config('services.bold.api_secret');
    $amount = $total;
    $currency = 'COP';

    // Generar la firma HMAC
    $integritySignature = hash_hmac('sha256', $orderId . $amount . $currency, $apiSecret);

    return view('carrito', [
        'orderId' => $orderId,
        'totalCarrito' => $total,
        'integritySignature' => $integritySignature
    ]);
}

}
