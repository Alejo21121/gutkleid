<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Productos por categoría
        $porCategoria = DB::table('productos')
            ->join('categorias', 'productos.id_categoria', '=', 'categorias.id_categoria')
            ->select('categorias.nombre as categoria', DB::raw('count(*) as cantidad'))
            ->groupBy('categoria')
            ->get();

        // Ventas por mes
        $ventasMensuales = DB::table('factura_ventas')
            ->select(DB::raw('MONTH(fecha_venta) as mes'), DB::raw('SUM(total) as total'))
            ->groupBy(DB::raw('MONTH(fecha_venta)'))
            ->get();

        // Total de clientes
        $totalClientes = DB::table('personas')->where('id_rol', 2)->count();

        // Total de productos registrados
        $totalProductos = DB::table('productos')->count();

        // 🔥 TOP 10 productos más vendidos
        $productosMasVendidos = DB::table('detalles_factura_v_s')
            ->join('productos', 'detalles_factura_v_s.id_producto', '=', 'productos.id_producto')
            ->select('productos.nombre as producto', DB::raw('SUM(detalles_factura_v_s.cantidad) as total_vendido'))
            ->groupBy('productos.nombre')
            ->orderByDesc('total_vendido')
            ->limit(10)
            ->get();

        return view('analisis', compact(
            'porCategoria',
            'ventasMensuales',
            'totalClientes',
            'totalProductos',
            'productosMasVendidos'
        ));
    }
}
