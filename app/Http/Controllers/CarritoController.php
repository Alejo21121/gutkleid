<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\FacturaVenta;
use App\Models\DetalleFacturaV;
use App\Models\MetodoPago;
use Illuminate\Support\Facades\DB;

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

                if ($producto->cantidad < $item['cantidad']) {
                    DB::rollBack();
                    return redirect()->route('carrito.index')->with('error', 'Cantidad insuficiente para ' . $producto->nombre);
                }

                $subtotal = $item['valor'] * $item['cantidad'];

                $detalle = new DetalleFacturaV();
                $detalle->id_factura_venta = $factura->id_factura_venta;
                $detalle->id_producto = $producto->id_producto;
                $detalle->cantidad = $item['cantidad'];
                $detalle->subtotal = $subtotal;
                $detalle->impuestos = 0.19; // Puedes ajustar esto si usas impuestos
                $detalle->id_impuesto = 1; // Cambia por el ID real del impuesto
                $detalle->save();

                $producto->cantidad -= $item['cantidad'];
                $producto->save();

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

        $carrito = session()->get('carrito', []);

        if (isset($carrito[$id_producto])) {
            $carrito[$id_producto]['cantidad'] += 1;
        } else {
            $carrito[$id_producto] = [
                "id_producto" => $id_producto,
                "nombre" => $nombre,
                "valor" => $valor,
                "cantidad" => 1
            ];
        }

        session()->put('carrito', $carrito);
        return redirect()->route('carrito.index')->with('success', 'Producto agregado al carrito.');
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