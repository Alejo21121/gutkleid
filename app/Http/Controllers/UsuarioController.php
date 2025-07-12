<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Persona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Exports\UsuariosExport;
use Maatwebsite\Excel\Facades\Excel;

class UsuarioController extends Controller
{
    // Método para editar el perfil del usuario logueado
    public function editar()
    {
        $usuario = session('usuario');

        // Asegurarse que es un array, no un objeto
        if (is_object($usuario)) {
            $usuario = (array) $usuario;
        }

        return view('editar_perfil', compact('usuario'));
    }

    // Método para actualizar el perfil del usuario logueado
    public function actualizar(Request $request)
    {
        $usuario = session('usuario');

        $request->validate([
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:255',
            'correo' => 'required|email|max:255|unique:personas,correo,' . $usuario['id_persona'] . ',id_persona',
            'contraseña' => 'nullable|string|min:6',
            'imagen' => 'nullable|image|max:2048', // Validar imagen
        ]);

        $dataToUpdate = [
            'nombres' => $request->input('nombres'),
            'apellidos' => $request->input('apellidos'),
            'telefono' => $request->input('telefono'),
            'direccion' => $request->input('direccion'),
            'correo' => $request->input('correo'),
        ];

        if ($request->filled('contraseña')) {
            $dataToUpdate['contraseña'] = Hash::make($request->input('contraseña'));
        }

        // 👉 Procesar imagen si se sube
        if ($request->hasFile('imagen')) {
            // Eliminar la imagen anterior (si existe y no es la imagen por defecto)
            if (!empty($usuario['imagen']) && file_exists(public_path($usuario['imagen'])) && $usuario['imagen'] !== 'IMG/default.jpeg') {
                unlink(public_path($usuario['imagen']));
            }

            // Guardar nueva imagen
            $imagen = $request->file('imagen');
            $nombreImagen = time() . '_' . $imagen->getClientOriginalName();
            $ruta = 'IMG/perfiles/' . $nombreImagen;
            $imagen->move(public_path('IMG/perfiles'), $nombreImagen);

            $dataToUpdate['imagen'] = $ruta;
        }

        // Actualizar en la base de datos
        DB::table('personas')->where('id_persona', $usuario['id_persona'])->update($dataToUpdate);

        // Refrescar sesión
        $usuarioActualizado = Usuario::where('id_persona', $usuario['id_persona'])->first();
        session(['usuario' => (array) $usuarioActualizado->toArray()]);

        return redirect()->route('cuenta')->with('success', 'Datos actualizados correctamente.');
    }

    // Método para mostrar la lista de usuarios con búsqueda y paginación
    public function index(Request $request)
    {

        $usuarios = Usuario::with('tipoDocumento')->paginate(10);

        $usuarios = Usuario::with('rol')->get();

        $buscar = $request->input('buscar');

        $query = Usuario::query();

        if ($request->has('buscar')) {
            $query->where('id_persona', $request->buscar);
        }

        $usuarios = $query->paginate(6)->appends(['buscar' => $buscar]);

        $paginaActual = $usuarios->currentPage();
        $totalPaginas = $usuarios->lastPage();

        return view('usuarios', compact('usuarios', 'buscar', 'paginaActual', 'totalPaginas'));
    }

    // Método para mostrar el formulario de creación de un nuevo usuario
    public function create()
    {
        $tipos = DB::table('tipo_documentos')->get();
        return view('createusur', compact('tipos'));
    }

    // Método para almacenar un nuevo usuario en la base de datos
    public function store(Request $request)
    {
        $request->validate([
            'documento' => 'required|string|max:20|unique:personas,documento',
            'id_tipo_documento' => 'required',
            'nombres' => 'required|string|max:50',
            'apellidos' => 'required|string|max:50',
            'telefono' => 'nullable|string|max:15',
            'correo' => 'required|email|max:50|unique:personas,correo',
            'contraseña' => 'required|string|min:6',
            'direccion' => 'required|string|max:100', // Mantenido
            // ELIMINADO: 'id_rol' => 'required|integer',
        ]);


        Usuario::create([
            'documento' => $request->documento,
            'id_tipo_documento' => $request->id_tipo_documento,
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'telefono' => $request->telefono,
            'correo' => $request->correo,
            'contraseña' => Hash::make($request->contraseña),
            'direccion' => $request->direccion, // Mantenido
            'id_rol' => 2
        ]);

        return redirect()->route('usuarios.index')->with('success', 'Usuario creado exitosamente.');
    }

    // Método para mostrar el formulario de edición de un usuario existente
    public function edit(Usuario $usuario)
    {
        $tipos = DB::table('tipo_documentos')->get(); // o TipoDocumento::all();
        return view('edit', compact('usuario', 'tipos'));
    }

    // Método para actualizar un usuario existente
    public function update(Request $request, Usuario $usuario)
    {
        $request->validate([
            'documento' => 'required|string|max:20|unique:personas,documento,' . $usuario->id_persona . ',id_persona',
            'id_tipo_documento' => 'required',
            'nombres' => 'required|string|max:50',
            'apellidos' => 'required|string|max:50',
            'direccion' => 'nullable|string|max:100',
            'telefono' => 'nullable|string|max:15',
            'correo' => 'required|email|max:50|unique:personas,correo,' . $usuario->id_persona . ',id_persona',
            'contraseña' => 'nullable|string|min:6',
        ]);

        $dataToUpdate = [
            'documento' => $request->documento,
            'id_tipo_documento' => $request->id_tipo_documento,
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'direccion' => $request->direccion,
            'telefono' => $request->telefono,
            'correo' => $request->correo,
        ];

        if ($request->filled('contraseña')) {
            $dataToUpdate['contraseña'] = Hash::make($request->contraseña);
        }

        $usuario->update($dataToUpdate);

        return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado correctamente.');
    }

    // Método para eliminar un usuario
    public function destroy(Usuario $usuario)
    {
        $usuario->delete();
        $page = request()->query('page');
        $buscar = request()->query('buscar');
        return redirect()->route('usuarios.index', ['page' => $page, 'buscar' => $buscar])
            ->with('success', 'Usuario eliminado correctamente.');
    }

    // Métodos para exportación
    public function exportarExcel()
    {
        return "Funcionalidad de exportar a Excel para usuarios no implementada aún.";
    }

    public function exportarPDF()
    {
        return "Funcionalidad de exportar a PDF para usuarios no implementada aún.";
    }

    public function eliminarImagen()
    {
        $usuario = session('usuario');

        if (!empty($usuario['imagen']) && file_exists(public_path($usuario['imagen'])) && $usuario['imagen'] !== 'IMG/default.jpeg') {
            unlink(public_path($usuario['imagen']));
        }

        DB::table('personas')->where('id_persona', $usuario['id_persona'])->update([
            'imagen' => null
        ]);

        // Actualiza en sesión
        $usuario['imagen'] = null;
        session(['usuario' => $usuario]);

        return redirect()->route('cuenta')->with('success', 'Imagen de perfil eliminada.');
    }

    public function actualizarDireccion(Request $request)
    {
        $request->validate([
            'direccion' => 'required|string|max:255',
            'info_adicional' => 'nullable|string',
        ]);

        $persona = Persona::find(session('usuario')['id_persona']);
        if ($persona) {
            $persona->direccion = $request->direccion;
            $persona->info_adicional = $request->info_adicional;
            $persona->save();

            // actualizar sesión
            session(['usuario' => $persona->toArray()]);
        }

        return back()->with('success', 'Dirección actualizada correctamente.');
    }
}
