<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FacturaCompra;
use App\Models\DetalleCompra;
use App\Models\Producto;
use App\Models\Proveedor;
use App\Models\Inventario;
use App\Models\Talla;
use Illuminate\Support\Facades\DB;

class ComprasController extends Controller
{
    public function index(Request $request)
    {
        $buscar = $request->input('buscar');

        $query = FacturaCompra::with(['proveedor', 'detalles.producto']);

        if (!empty($buscar)) {
            $query->where('id_factura_compras', $buscar);
        }

        $compras = $query->orderByDesc('fecha_compra')->paginate(6);

        return view('compras', compact('compras', 'buscar'));
    }

    public function create()
    {
        $productos = Producto::with('tallas')->get(); // Para obtener las tallas disponibles
        $proveedores = Proveedor::all();
        return view('createcompras', compact('productos', 'proveedores'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            // ✅ Quitamos 'id_inventario' porque ya no existe
            $factura = FacturaCompra::create([
                'valor' => $request->input('valor_total'),
                'fecha_compra' => now(),
                'estado' => 'Realizada',
                'id_proveedor' => $request->input('id_proveedor')
            ]);

            foreach ($request->input('productos') as $productoData) {
                $producto = Producto::find($productoData['id']);

                foreach ($productoData['tallas'] as $tallaData) {
                    $total = $tallaData['cantidad'] * $tallaData['precio'];

                    DetalleCompra::create([
                        'id_factura_compras' => $factura->id_factura_compras,
                        'id_producto' => $producto->id_producto,
                        'valor_unitario' => $tallaData['precio'],
                        'total' => $total,
                    ]);

                    // Actualizar inventario general
                    $inventario = Inventario::where('id_producto', $producto->id_producto)->first();
                    if ($inventario) {
                        $inventario->stock += $tallaData['cantidad'];
                        $inventario->precio_compras = $tallaData['precio'];
                        $inventario->fecha_salida = null;
                        $inventario->save();
                    } else {
                        Inventario::create([
                            'id_producto' => $producto->id_producto,
                            'stock' => $tallaData['cantidad'],
                            'precio_compras' => $tallaData['precio'],
                            'precio_ventas' => $producto->valor,
                            'fecha_salida' => null,
                        ]);
                    }

                    // Actualizar cantidad por talla
                    $talla = Talla::where('id_producto', $producto->id_producto)
                        ->where('talla', $tallaData['talla'])
                        ->first();

                    if ($talla) {
                        $talla->cantidad += $tallaData['cantidad'];
                        $talla->save();
                    } else {
                        Talla::create([
                            'id_producto' => $producto->id_producto,
                            'talla' => $tallaData['talla'],
                            'cantidad' => $tallaData['cantidad'],
                        ]);
                    }
                }
            }

            DB::commit();
            return redirect()->route('compras.index')->with('success', 'Compra registrada correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al guardar la compra: ' . $e->getMessage());
        }
    }
}
