<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use Illuminate\Support\Facades\DB;

use App\Exports\ProductosExport;
use Maatwebsite\Excel\Facades\Excel;

use App\Models\Categoria;

use App\Models\Imagen;
use App\Models\Talla;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ProductoController extends Controller
{
public function index(Request $request)
{
    $buscar = $request->input('buscar');

    $query = Producto::with(['categoria', 'imagenes', 'tallas']);


    if (!empty($buscar)) {
        $query->where('id_producto', $buscar);
    }

    $productos = $query->paginate(6)->appends(['buscar' => $buscar]);

    $advertencias = [];

    foreach ($productos as $producto) {
        foreach ($producto->tallas as $talla) {
            if ($talla->cantidad <= 5) { 
                $advertencias[] = [
                    'id' => $producto->id_producto,
                    'nombre' => $producto->nombre,
                    'talla' => $talla->talla,
                    'cantidad' => $talla->cantidad,
                ];
            }
        }
    }

    $paginaActual = $productos->currentPage();
    $totalPaginas = $productos->lastPage();

    // Cargar categorías con conteo de productos
    $categoriasConCantidad = Categoria::withCount('productos')->get();

    return view('inventario', compact('productos', 'buscar', 'paginaActual', 'totalPaginas', 'categoriasConCantidad', 'advertencias'));
}

    public function create()
    {
        $categorias = Categoria::all(); 
        return view('create', compact('categorias'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'valor' => 'required|numeric|min:0',
            'marca' => 'required|string|max:255',
            'color' => 'required|string|max:100',
            'id_categoria' => 'required|exists:categorias,id_categoria',
            'tallas' => 'required|array',
            'tallas.*.talla' => 'required|string|max:10',
            'tallas.*.cantidad' => 'required|integer|min:0',
        ]);

        // Crear el producto
        $producto = Producto::create([
            'nombre' => $validated['nombre'],
            'valor' => $validated['valor'],
            'marca' => $validated['marca'],
            'color' => $validated['color'],
            'id_categoria' => $validated['id_categoria'],
        ]);

        // Agregar las tallas asociadas
        foreach ($validated['tallas'] as $talla) {
            Talla::create([
                'id_producto' => $producto->id_producto,
                'talla' => $talla['talla'],
                'cantidad' => $talla['cantidad'],
            ]);
        }

        return redirect()->route('producto.index')->with('success', 'Producto creado con tallas.');
    }

    public function show(Producto $producto)
    {
        return "Mostrando detalles del producto con ID: " . $producto->id_producto;
    }

    public function edit(Producto $producto)
    {
        $categorias = Categoria::all(); 
        return view('producto_edit', compact('producto', 'categorias'));
    }

    public function update(Request $request, Producto $producto)
    {
        // Validación 
        $request->validate([
            'nombre' => 'required|string|max:255',
            'valor' => 'required|numeric|min:0',
            'marca' => 'required|string|max:255',
            'color' => 'required|string|max:100',
            'id_categoria' => 'required|exists:categorias,id_categoria',
            'tallas' => 'required|array|min:1',
            'tallas.*.talla' => 'required|string|max:50',
            'tallas.*.cantidad' => 'required|integer|min:0',
        ]);

        // Actualizar producto
        $producto->update($request->only([
            'nombre', 'valor', 'marca', 'color', 'id_categoria'
        ]));

        // Borrar tallas actuales
        $producto->tallas()->delete();

        // Agregar nuevas tallas
        foreach ($request->input('tallas') as $t) {
            if (!empty($t['talla']) && isset($t['cantidad'])) {
                $producto->tallas()->create([
                    'talla' => $t['talla'],
                    'cantidad' => $t['cantidad'],
                ]);
            }
        }

        return redirect()->route('producto.index')->with('success', 'Producto actualizado correctamente.');
    }

        public function destroy(Producto $producto)
        {
            $producto->delete();
            $page = request()->query('page');
            $buscar = request()->query('buscar');

            return redirect()->route('producto.index', ['page' => $page, 'buscar' => $buscar])
                            ->with('success', 'Producto eliminado correctamente.');
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
        $imagenes = $producto->imagenes; 

        return view('producto_imagenes', compact('producto', 'imagenes'));
    }

    // Subir nuevas imágenes
   
   public function subirImagen(Request $request, $id)
{
    $request->validate([
        'imagenes.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048'
    ]);

    $producto = Producto::with('imagenes')->findOrFail($id);

    if ($producto->imagenes->count() >= 4) {
        return redirect()->route('producto.imagenes', $id)->with('error', 'Ya hay 4 imágenes para este producto.');
    }

    $imagenesNuevas = $request->file('imagenes') ?? [];

    foreach ($imagenesNuevas as $img) {
        $nombreOriginal = $img->getClientOriginalName();
        $rutaDestino = public_path("IMG/imagenes_demo/{$nombreOriginal}");

        // Si no existe ya la imagen, se guarda
        if (!File::exists($rutaDestino)) {
            $img->move(public_path('IMG/imagenes_demo'), $nombreOriginal);
        }

        // Registrar en la base de datos
        Imagen::create([
            'id_producto' => $id,
            'ruta' => 'IMG/imagenes_demo/' . $nombreOriginal
        ]);
    }

    return redirect()->route('producto.imagenes', $id)->with('success', '✅ Imágenes agregadas.');
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
