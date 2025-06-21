<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use Illuminate\Support\Facades\DB;

use App\Exports\ProductosExport;
use Maatwebsite\Excel\Facades\Excel;

class ProductoController extends Controller
{
public function index(Request $request)
{
    $buscar = $request->input('buscar');

    $query = Producto::query();

    if (!empty($buscar)) {
        $query->where('id_producto', $buscar);
    }

    // El método appends(['buscar' => $buscar]) asegura que el filtro se mantenga en la paginación
    $productos = $query->paginate(6)->appends(['buscar' => $buscar]);

    $paginaActual = $productos->currentPage();
    $totalPaginas = $productos->lastPage();

    return view('inventario', compact('productos', 'buscar', 'paginaActual', 'totalPaginas'));
}


    public function create()
    {
        return view('create');
    }

    public function store(Request $request)
    {
        $request->validate([
        'id_producto' => 'required|integer',
        'nombre' => 'required|string|max:255',
        'valor' => 'required|numeric|min:0',
        'marca' => 'required|string|max:255',
        'talla' => 'required|string|max:50',
        'color' => 'required|string|max:100',
        'categoria' => 'required|string|max:100',
    ]);

      DB::table('productos')->insert($request->only([
            'id_producto', 'nombre', 'valor', 'marca', 'talla', 'color', 'categoria'
        ]));

        return redirect()->route('producto.index')->with('success', 'Producto agregado exitosamente.');
    }

    public function show(Producto $producto)
    {
        return "Mostrando detalles del producto con ID: " . $producto->id_producto;
    }

public function edit(Producto $producto)
{
    return view('producto_edit', compact('producto'));
}

public function update(Request $request, Producto $producto)
{
        $request->validate([
        'nombre' => 'required|string|max:255',
        'valor' => 'required|numeric|min:0',
        'marca' => 'required|string|max:255',
        'talla' => 'required|string|max:50',
        'color' => 'required|string|max:100',
        'categoria' => 'required|string|max:100',
    ]);

        $producto->update($request->only([
        'nombre', 'valor', 'marca', 'talla', 'color', 'categoria'
    ]));

    return redirect()->route('producto.index')->with('success', 'Producto actualizado correctamente.');
}
    public function destroy(Producto $producto)
    {
        $producto->delete();
        return redirect()->route('producto.index')->with('success', 'Producto eliminado correctamente.');
    }

    public function exportarExcel()
    {
        return Excel::download(new ProductosExport, 'productos.xlsx');
    }

    public function exportarPDF()
    {
        return "Exportando productos a PDF...";
    }
}
