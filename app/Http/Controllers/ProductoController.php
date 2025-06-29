<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use Illuminate\Support\Facades\DB;

use App\Exports\ProductosExport;
use Maatwebsite\Excel\Facades\Excel;

use App\Models\Categoria;

use App\Models\Imagen;
use Illuminate\Support\Facades\Storage;

class ProductoController extends Controller
{
public function index(Request $request)
{
    $buscar = $request->input('buscar');

    $query = Producto::with(['categoria', 'imagenes']); // Cargar relación

    if (!empty($buscar)) {
        $query->where('id_producto', $buscar);
    }

    $productos = $query->paginate(6)->appends(['buscar' => $buscar]);

    $paginaActual = $productos->currentPage();
    $totalPaginas = $productos->lastPage();

    // Cargar categorías con conteo de productos
    $categoriasConCantidad = Categoria::withCount('productos')->get();

    return view('inventario', compact('productos', 'buscar', 'paginaActual', 'totalPaginas', 'categoriasConCantidad'));
}

    public function create()
    {
        $categorias = Categoria::all(); // Traer todas las categorías
        return view('create', compact('categorias'));
    }

    public function store(Request $request)

    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'valor' => 'required|numeric|min:0',
            'marca' => 'required|string|max:255',
            'talla' => 'required|string|max:50',
            'color' => 'required|string|max:100',
            'id_categoria' => 'required|exists:categorias,id_categoria',
            'cantidad' => 'required|integer|min:0',
        ]);

        DB::table('productos')->insert($request->only([
            'nombre', 'valor', 'marca', 'talla', 'color', 'id_categoria', 'cantidad'
        ]));

        return redirect()->route('producto.index')->with('success', 'Producto agregado exitosamente.');
    }

    public function show(Producto $producto)
    {
        return "Mostrando detalles del producto con ID: " . $producto->id_producto;
    }

    public function edit(Producto $producto)
    {
        $categorias = Categoria::all(); // Necesario para llenar el <select>
        return view('producto_edit', compact('producto', 'categorias'));
    }

    public function update(Request $request, Producto $producto)
    {
            $request->validate([
            'nombre' => 'required|string|max:255',
            'valor' => 'required|numeric|min:0',
            'marca' => 'required|string|max:255',
            'talla' => 'required|string|max:50',
            'color' => 'required|string|max:100',
            'id_categoria' => 'required|exists:categorias,id_categoria',
            'cantidad' => 'required|integer|min:0',
        ]);

            $producto->update($request->only([
            'nombre', 'valor', 'marca', 'talla', 'color', 'id_categoria', 'cantidad'
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

        public function verProducto($id)
        {
            $producto = Producto::with(['imagenes', 'categoria'])->findOrFail($id);
            return view('producto_ver', compact('producto'));
        }

    // Ver vista para gestionar imágenes
    public function gestionarImagenes($id)
    {
        $producto = Producto::findOrFail($id);
        $imagenes = $producto->imagenes; // relación hasMany

        return view('producto_imagenes', compact('producto', 'imagenes'));
    }

    // Subir nuevas imágenes
    public function subirImagen(Request $request, $id)
    {
        $request->validate([
        'imagenes.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048'
    ]);


        if ($request->hasFile('imagenes')) {
            foreach ($request->file('imagenes') as $img) {
                $ruta = $img->store('productos', 'public');

                Imagen::create([
                    'id_producto' => $id,
                    'ruta' => $ruta
                ]);
            }
        }

        return redirect()->route('producto.imagenes', $id)->with('success', 'Imágenes agregadas.');
    }

    // Eliminar una imagen
    public function eliminarImagen($id)
    {
        $imagen = Imagen::findOrFail($id);
        Storage::disk('public')->delete($imagen->ruta);
        $imagen->delete();

        return back()->with('success', 'Imagen eliminada.');
    }

        public function paginaInicio()
    {
        $productos = Producto::with('imagenes')->get();
        return view('inicio', compact('productos'));
    }

}
