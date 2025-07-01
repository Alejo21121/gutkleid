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

        // Total de productos registrados (por ID único)
        $totalProductos = DB::table('productos')->count();

        return view('analisis', compact('porCategoria', 'ventasMensuales', 'totalClientes', 'totalProductos'));
    }
}
