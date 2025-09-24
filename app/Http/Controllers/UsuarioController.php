<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Persona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use Barryvdh\DomPDF\Facade\Pdf;

use Shuchkin\SimpleXLSXGen;

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
            'nombres' => ['required', 'string', 'max:50', 'regex:/^[A-Za-zÁÉÍÓÚáéíóúñÑ\s]+$/'],
            'apellidos' => ['required', 'string', 'max:50', 'regex:/^[A-Za-zÁÉÍÓÚáéíóúñÑ\s]+$/'],
            'telefono' => ['required', 'digits:10', 'regex:/^[0-9]{10}$/'],
            'correo' => 'required|email|max:255|unique:personas,correo,' . $usuario['id_persona'] . ',id_persona',
            'contraseña' => [
                'nullable', // 👈 ahora no es obligatoria
                'string',
                'min:6',
                'regex:/^(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9]).+$/'
            ],
            'imagen' => 'nullable|image|max:2048', // Validar imagen
        ], [

            // Mensajes personalizados
            'correo.unique' => 'El correo ya está registrado',
            'contraseña.min' => 'La contraseña debe tener al menos 8 caracteres',
            'contraseña.regex' => 'La contraseña debe tener al menos una mayúscula, un número y un carácter especial',
            'required' => 'El campo :attribute es obligatorio.',
            'email' => 'El campo :attribute debe ser un correo válido.',
            'nombres.regex' => 'El campo nombres solo puede contener letras',
            'apellidos.regex' => 'El campo apellidos solo puede contener letras ',
            'telefono.digits' => 'El número de teléfono debe tener 10 numeros exactamente',
            'telefono.numeric'  => 'El teléfono solo debe tener números.'

        ]);

        $dataToUpdate = [
            'nombres' => $request->input('nombres'),
            'apellidos' => $request->input('apellidos'),
            'telefono' => $request->input('telefono'),
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
            'nombres' => ['required', 'string', 'max:50', 'regex:/^[A-Za-zÁÉÍÓÚáéíóúñÑ\s]+$/'],
            'apellidos' => ['required', 'string', 'max:50', 'regex:/^[A-Za-zÁÉÍÓÚáéíóúñÑ\s]+$/'],
            'telefono' => ['required', 'digits:10', 'regex:/^[0-9]{10}$/'],
            'correo' => 'required|email|max:50|unique:personas,correo',
            'contraseña' => [
                'required',
                'string',
                'min:6',
                'regex:/^(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9]).+$/'
            ],
            'direccion' => 'required|string|max:100', // Mantenido
        ], [

            // Mensajes personalizados
            'correo.unique' => 'El correo ya está registrado',
            'contraseña.min' => 'La contraseña debe tener al menos 8 caracteres',
            'contraseña.regex' => 'La contraseña debe tener al menos una mayúscula, un número y un carácter especial',
            'required' => 'El campo :attribute es obligatorio.',
            'email' => 'El campo :attribute debe ser un correo válido.',
            'nombres.regex' => 'El campo nombres solo puede contener letras',
            'apellidos.regex' => 'El campo apellidos solo puede contener letras ',
            'telefono.digits' => 'El número de teléfono debe tener 10 numeros exactamente',
            'telefono.numeric'  => 'El teléfono solo debe tener números.'

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
            'nombres' => ['required', 'string', 'max:50', 'regex:/^[A-Za-zÁÉÍÓÚáéíóúñÑ\s]+$/'],
            'apellidos' => ['required', 'string', 'max:50', 'regex:/^[A-Za-zÁÉÍÓÚáéíóúñÑ\s]+$/'],
            'direccion' => 'nullable|string|max:100',
            'telefono' => ['required', 'digits:10', 'regex:/^[0-9]{10}$/'],
            'correo' => 'required|email|max:50|unique:personas,correo,' . $usuario->id_persona . ',id_persona',
            'contraseña' => [
                'required',
                'string',
                'min:6',
                'regex:/^(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9]).+$/'
            ],
        ],  [

            // Mensajes personalizados
            'correo.unique' => 'El correo ya está registrado',
            'contraseña.min' => 'La contraseña debe tener al menos 8 caracteres',
            'contraseña.regex' => 'La contraseña debe tener al menos una mayúscula, un número y un carácter especial',
            'required' => 'El campo :attribute es obligatorio.',
            'email' => 'El campo :attribute debe ser un correo válido.',
            'nombres.regex' => 'El campo nombres solo puede contener letras',
            'apellidos.regex' => 'El campo apellidos solo puede contener letras ',
            'telefono.digits' => 'El número de teléfono debe tener 10 numeros exactamente',
            'telefono.numeric'  => 'El teléfono solo debe tener números.'

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
    // Cargar los usuarios con sus relaciones tipoDocumento y rol
    $usuarios = Usuario::with(['tipoDocumento', 'rol'])->get();

    // Encabezados de la tabla, exactamente como aparecen en tu vista
    $header = [
        'ID Persona',
        'Documento',
        'Tipo Doc',
        'Nombres',
        'Apellidos',
        'Telefono',
        'Correo',
        'Rol',
    ];

    // Preparamos los datos para la exportación
    $data = [];
    foreach ($usuarios as $usuario) {
        $data[] = [
            $usuario->id_persona,
            $usuario->documento,
            // Acceder a la propiedad 'nombre' de la relación 'tipoDocumento'
            $usuario->tipoDocumento->nombre ?? 'N/A', 
            $usuario->nombres,
            $usuario->apellidos,
            $usuario->telefono,
            $usuario->correo,
            // Acceder a la propiedad 'nombre' de la relación 'rol'
            $usuario->rol->nombre ?? 'N/A', 
        ];
    }

    // Unimos los encabezados con los datos
    array_unshift($data, $header);

    // Generamos el archivo de Excel y lo descargamos
    $xlsx = \Shuchkin\SimpleXLSXGen::fromArray($data);
    return response($xlsx->downloadAs('usuarios.xlsx'))->header('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
}

    public function exportarPDF()
    {
        $usuarios = Usuario::with(['tipoDocumento', 'rol'])->get();
        
        // Aquí es donde corregimos el nombre de la vista
        $pdf = Pdf::loadView('usuarios_pdf', compact('usuarios'));
        
        return $pdf->stream('reporte_usuarios.pdf');
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

        return redirect()->route('cuenta')->with('success', 'Dirección actualizada correctamente.');
    }

    public function historial()
{
    $id_persona = session('usuario')['id_persona'];

    $facturas = DB::table('factura_ventas as f')
        ->join('personas as p', 'p.id_persona', '=', 'f.id_persona')
        ->join('metodo_pagos as m', 'm.id_metodo_pago', '=', 'f.id_metodo_pago')
        ->leftJoin('sub_metodos_pago as sm', 'sm.id_sub_metodo', '=', 'f.id_sub_metodo')
        ->where('f.id_persona', $id_persona)
        ->select(
            'f.id_factura_venta',
            'f.fecha_venta',
            'f.total',
            'f.envio',
            'f.entrega',
            'm.nombre as metodo_pago',
            'sm.nombre as sub_metodo_pago', // 👈 aquí
            'p.nombres',
            'p.direccion',
            'p.telefono'
        )
        ->orderByDesc('f.fecha_venta')
        ->get();

    foreach ($facturas as $factura) {
        $factura->detalles = DB::table('detalles_factura_v_s as d')
            ->join('productos as pr', 'pr.id_producto', '=', 'd.id_producto')
            ->leftJoin('tallas as t', 't.id', '=', 'd.id_talla')
            ->where('d.id_factura_venta', $factura->id_factura_venta)
            ->select(
                'pr.nombre as nombre_producto',
                'pr.color',
                'pr.marca',
                DB::raw('(SELECT ruta FROM imagenes WHERE id_producto = pr.id_producto LIMIT 1) as imagen'),
                't.talla',
                'd.subtotal',
                'd.iva',
                'd.cantidad'
            )
            ->get();
    }

    return view('historial', compact('facturas'));
}


    public function ventas(Request $request)
    {
        $buscar = $request->input('buscar');

        $ventas = DB::table('factura_ventas as f')
            ->join('personas as p', 'p.id_persona', '=', 'f.id_persona')
            ->select(
                'f.id_factura_venta',
                'f.fecha_venta',
                'f.total',
                'p.nombres',
                'p.apellidos',
                'f.factura_pdf',
                'p.documento'
            )
            ->when($buscar, function ($query, $buscar) {
                return $query->where('f.id_factura_venta', $buscar);
            })
            ->orderByDesc('f.fecha_venta')
            ->paginate(10);

        return view('ventas', compact('ventas', 'buscar'));
    }
}
