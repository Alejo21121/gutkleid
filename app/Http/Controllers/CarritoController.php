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

            $metodo = MetodoPago::find(1);
            if (!$metodo) {
                return redirect()->route('carrito.index')->with('error', 'Método de pago no existe.');
            }

            $factura->id_metodo_pago = $metodo->id_metodo_pago;
            $factura->total = 0;
            $factura->save();

            $total = 0;

            foreach ($carrito as $item) {
                $producto = Producto::where('id_producto', $item['id_producto'])->first();

                if (!$producto) {
                    DB::rollBack();
                    return redirect()->route('carrito.index')->with('error', 'Producto no encontrado.');
                }

                // Validar y limpiar talla
                $tallaBuscada = strtoupper(trim($item['talla'] ?? ''));

                if (empty($tallaBuscada)) {
                    DB::rollBack();
                    return redirect()->route('carrito.index')->with('error', 'Falta seleccionar talla para el producto ' . $producto->nombre);
                }

                // Buscar talla específica del producto
                $tallaProducto = Talla::where('id_producto', $producto->id_producto)
                                      ->where('talla', $tallaBuscada)
                                      ->first();

                if (!$tallaProducto) {
                    DB::rollBack();
                    return redirect()->route('carrito.index')->with('error', 'No se encontró la talla ' . $tallaBuscada . ' para el producto ' . $producto->nombre);
                }

                if ($tallaProducto->cantidad < $item['cantidad']) {
                    DB::rollBack();
                    return redirect()->route('carrito.index')->with('error', 'Stock insuficiente para talla ' . $item['talla'] . ' del producto ' . $producto->nombre);
                }

                $subtotal = $item['valor'] * $item['cantidad'];

                $detalle = new DetalleFacturaV();
                $detalle->id_factura_venta = $factura->id_factura_venta;
                $detalle->id_producto = $producto->id_producto;
                $detalle->cantidad = $item['cantidad'];
                $detalle->subtotal = $subtotal;
                $detalle->impuestos = 0.19;
                $detalle->id_impuesto = 1;
                $detalle->save();

                // Descontar stock de la talla
                $tallaProducto->cantidad -= $item['cantidad'];
                $tallaProducto->save();

                $total += $subtotal;
            }

            $factura->total = $total;
            $factura->save();

            DB::commit();
            session()->forget('carrito');

            return redirect()->route('carrito.index')->with('success', 'Compra registrada con éxito.');
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
        $color = $request->input('color');
        $talla = strtoupper(trim($request->input('talla')));
        $cantidad = max((int) $request->input('cantidad', 1), 1);

        // Validar talla
        if (empty($talla)) {
            return redirect()->route('carrito.index')->with('error', 'Debe seleccionar una talla para continuar.');
        }

        $producto = Producto::with('imagenes')->findOrFail($id_producto);

        $rutaImagen = $producto->imagenes->first()->ruta ?? 'IMG/default.jpg';
        $rutaCompleta = 'IMG/imagenes_demo/' . basename($rutaImagen);

        $carrito = session()->get('carrito', []);

        $clave = $id_producto . '-' . strtolower($color) . '-' . $talla;

        if (isset($carrito[$clave])) {
            $carrito[$clave]['cantidad'] += $cantidad;
        } else {
            $carrito[$clave] = [
                "id_producto" => $id_producto,
                "nombre" => $nombre,
                "valor" => $valor,
                "color" => $color,
                "talla" => $talla,
                "cantidad" => $cantidad,
                "imagen" => $rutaCompleta
            ];
        }

        session()->put('carrito', $carrito);

        return redirect()->route('carrito.index')->with('success', 'Producto agregado al carrito.');
    }

    public function actualizarCantidad(Request $request, $id_producto)
    {
        $carrito = session()->get('carrito', []);

        if (isset($carrito[$id_producto])) {
            $tipo = $request->input('tipo');

            if ($tipo === 'sumar') {
                $carrito[$id_producto]['cantidad'] += 1;
            } elseif ($tipo === 'restar' && $carrito[$id_producto]['cantidad'] > 1) {
                $carrito[$id_producto]['cantidad'] -= 1;
            }

            session()->put('carrito', $carrito);
        }

        return redirect()->route('carrito.index');
    }

    public function eliminar($id_producto)
    {
        $carrito = session()->get('carrito', []);
        if (isset($carrito[$id_producto])) {
            unset($carrito[$id_producto]);
            session()->put('carrito', $carrito);
        }
        return redirect()->back()->with('success', 'Producto eliminado del carrito.');
    }

    public function vaciar()
    {
        session()->forget('carrito');
        return redirect()->back()->with('success', 'Carrito vaciado.');
    }
}
