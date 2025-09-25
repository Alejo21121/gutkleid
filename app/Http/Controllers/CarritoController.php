<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\FacturaVenta;
use App\Models\DetalleFacturaV;
use App\Models\MetodoPago;
use App\Models\Persona;
use Illuminate\Support\Facades\DB;
use App\Models\Talla;
use Illuminate\Support\Facades\Mail;
use App\Mail\FacturaMail;
use Barryvdh\DomPDF\Facade\Pdf;

class CarritoController extends Controller
{
    public function index()
    {
        $carrito = session()->get('carrito', []);
        $totalFinal = 0;
        foreach ($carrito as $item) {
            $totalFinal += ($item['valor'] ?? 0) * ($item['cantidad'] ?? 0);
        }
        return view('carrito', compact('carrito', 'totalFinal'));
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
            return redirect()->route('carrito.index')->with('error', 'Debe seleccionar una talla.');
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
                "imagen" => $rutaCompleta,
                "total" => $valor * $cantidad
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

    public function guardarEnvio(Request $request)
    {
        $carrito = session()->get('carrito', []);
        $usuario = session('usuario');
        $persona = Persona::find($usuario['id_persona']);

        $envio = $request->only(['tipo_entrega', 'direccion', 'info_adicional']);

        // Calcular subtotal e IVA
        $subtotal = 0;
        foreach ($carrito as $item) $subtotal += $item['valor'] * $item['cantidad'];
        $ivaTotal = round($subtotal * 0.19, 0);

        // Costo de envío
        $costoEnvio = ($envio['tipo_entrega'] === 'domicilio') ? (($subtotal >= 150000) ? 0 : 15000) : 0;

        // Dirección real
        if ($envio['tipo_entrega'] === 'tienda') {
            $direccionReal = 'Tv 79 #68 Sur-98a';
        } else {
            $direccionReal = $envio['direccion'] ?? $persona->direccion;
            if (!empty($envio['direccion']) && $envio['direccion'] !== $persona->direccion) {
                $persona->direccion = $direccionReal;
                $persona->save();
                $usuario['direccion'] = $direccionReal;
                session(['usuario' => $usuario]);
            }
        }

        $envio['direccion'] = $direccionReal;
        $envio['info_adicional'] = $envio['info_adicional'] ?? '';

        $totalFinal = $subtotal + $ivaTotal + $costoEnvio;

        session([
            'carrito' => $carrito,
            'subtotal' => $subtotal,
            'ivaTotal' => $ivaTotal,
            'costoEnvio' => $costoEnvio,
            'totalFinal' => $totalFinal,
            'persona' => $persona,
            'envio' => $envio
        ]);

        return redirect()->route('metodo_pago.index');
    }

    public function finalizar(Request $request)
    {
        $carrito = session('carrito', []);
        $usuario = session('usuario');

        if (empty($carrito)) return redirect()->route('carrito.index')->with('error', 'El carrito está vacío.');
        if (empty($usuario) || !isset($usuario['id_persona'])) return redirect()->route('login')->with('error', 'Debes iniciar sesión.');

        $envio = session('envio', []);
        $tipoEntrega = $envio['tipo_entrega'] ?? 'domicilio';
        $direccion = $envio['direccion'] ?? ($tipoEntrega === 'tienda' ? 'Tv 79 #68 Sur-98a' : ($usuario['direccion'] ?? 'No registrada'));

        $infoAdicional = $request->info_adicional ?? $envio['info_adicional'] ?? '';
        session(['info_adicional' => $infoAdicional]);

        DB::beginTransaction();
        try {
            $idMetodoPagoSeleccionado = session('metodo_pago');
            if (is_string($idMetodoPagoSeleccionado) && !is_numeric($idMetodoPagoSeleccionado)) {
                $metodo = MetodoPago::where('nombre', $idMetodoPagoSeleccionado)->first();
                $idMetodoPagoSeleccionado = $metodo->id_metodo_pago ?? MetodoPago::first()->id_metodo_pago ?? 1;
            }

            $factura = new FacturaVenta();
            $factura->fecha_venta = now();
            $factura->nit_tienda = '123456789';
            $factura->dire_tienda = 'Tv 79 #68 Sur-98a';
            $factura->telef_tienda = '3001234567';
            $factura->id_persona = $usuario['id_persona'];
            $factura->id_metodo_pago = $idMetodoPagoSeleccionado;
            $factura->info_adicional = $infoAdicional;
            $factura->total = 0;
            $factura->envio = 0;
            $factura->entrega = $tipoEntrega;
            $factura->save();

            // 🔹 Variables para acumular los totales generales
            $subtotalGeneral = 0;
            $ivaGeneral = 0;
            $totalGeneral = 0;

            foreach ($carrito as $item) {
                $producto = Producto::find($item['id_producto']);
                if (!$producto) throw new \Exception('Producto no encontrado');

                $tallaProducto = Talla::where('id_producto', $producto->id_producto)
                    ->where('talla', strtoupper(trim($item['talla'])))
                    ->first();
                if (!$tallaProducto || $tallaProducto->cantidad < $item['cantidad']) {
                    throw new \Exception("Stock insuficiente para {$producto->nombre} talla {$item['talla']}");
                }

                $cantidad = $item['cantidad'];
                $valorUnitario = $item['valor'] ?? 0;

                // ✅ Lógica de cálculo del PDF con redondeo
                $ivaUnit = round($valorUnitario * 0.19, 0); // Redondea el IVA a un número entero
                $valorUnitConIva = round($valorUnitario + $ivaUnit, -3); // Redondea el total unitario a la centena más cercana

                // ✅ Calcular los totales para este ítem
                $totalItem = $valorUnitConIva * $cantidad;
                $subtotalItem = $valorUnitario * $cantidad;
                $ivaItem = $totalItem - $subtotalItem;

                // 🔹 Guardar detalle en BD
                $detalle = new DetalleFacturaV();
                $detalle->id_factura_venta = $factura->id_factura_venta;
                $detalle->id_producto = $producto->id_producto;
                $detalle->id_talla = $tallaProducto->id;
                $detalle->cantidad = $cantidad;
                $detalle->subtotal = $subtotalItem;
                $detalle->iva = $ivaItem;
                $detalle->color = $item['color'] ?? 'N/A';
                $detalle->save();

                // 🔹 Restar stock
                $tallaProducto->cantidad -= $cantidad;
                $tallaProducto->save();

                // 🔹 Acumular los totales generales
                $subtotalGeneral += $subtotalItem;
                $ivaGeneral += $ivaItem;
                $totalGeneral += $totalItem;
            }

            // 🔹 Calcular costo de envío
            $costoEnvio = ($tipoEntrega === 'tienda') ? 0 : (($totalGeneral >= 150000) ? 0 : 15000);

            // 🔹 Guardar totales en la factura principal
            $factura->envio = $costoEnvio;
            $factura->total = $totalGeneral + $costoEnvio;
            $factura->save();

            DB::commit();

            // Generar PDF y enviar correo
            $pdf = Pdf::loadView('factura_pdf', [
                'factura' => $factura->load(['detalles.producto', 'detalles.talla', 'cliente']),
                'metodo_pago' => MetodoPago::find($idMetodoPagoSeleccionado)->nombre ?? '—',
                'sub_metodo' => session('sub_metodo_pago'),
                'direccionCliente' => $direccion,
                'tipoEntregaTexto' => ($tipoEntrega === 'tienda' ? 'Recoger en tienda' : 'Domicilio'),
                'infoAdicional' => $infoAdicional
            ]);

            $nombreArchivo = 'Factura_GutKleid_' . $factura->id_factura_venta . '.pdf';
            $rutaArchivo = 'facturas/' . $nombreArchivo;
            if (!file_exists(public_path('facturas'))) mkdir(public_path('facturas'), 0777, true);
            $pdf->save(public_path($rutaArchivo));

            $factura->factura_pdf = $rutaArchivo;
            $factura->save();

            if (!empty($usuario['correo'])) {
                Mail::to($usuario['correo'])->send(new FacturaMail($factura, public_path($rutaArchivo)));
            }

            session()->forget('carrito');

            return redirect()->route('confirmacion.final', ['id_factura' => $factura->id_factura_venta]);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('carrito.index')->with('error', 'Error al finalizar la compra: ' . $e->getMessage());
        }
    }

    public function mostrarConfirmacionFinal($id_factura)
    {
        try {
            $factura = FacturaVenta::with(['detalles.producto', 'cliente', 'detalles.talla'])->findOrFail($id_factura);
            return view('confirmacion_final', compact('factura'));
        } catch (\Exception $e) {
            return redirect()->route('historial')->with('error', 'Factura no encontrada.');
        }
    }

    public function generarFacturaPDF($id_factura)
    {
        try {
            $factura = FacturaVenta::with([
                'detalles.producto',
                'cliente',
                'detalles.talla',
                'metodoPago',
                'subMetodoPago'
            ])->findOrFail($id_factura);

            $pdf = Pdf::loadView('factura_pdf', [
                'factura' => $factura,
                'metodo_pago' => $factura->metodoPago->nombre ?? '—',
                'sub_metodo' => $factura->subMetodoPago->nombre ?? null
            ]);

            $nombreArchivo = 'Factura_GutKleid_' . $factura->id_factura_venta . '.pdf';
            return $pdf->stream($nombreArchivo);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al generar el PDF: ' . $e->getMessage());
        }
    }
}
