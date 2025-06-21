<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class RegistroController extends Controller
{

    public function mostrarFormulario() {
        $tipos = DB::table('tipo_documentos')->get(); // Obtener los tipos desde la BD
        return view('registro', compact('tipos'));   // Pasarlos a la vista
    }

    public function registrar(Request $request) {
    
    $request->validate([
        'documento' => 'required',
        'id_tipo_documento' => 'required',
        'nombres' => 'required',
        'apellidos' => 'required',
        'direccion' => 'required',
        'telefono' => 'required',
        'correo' => 'required|email|unique:personas,correo',
        'contraseña' => 'required|confirmed|min:6',
    ], [
        'correo.unique' => 'El correo ya está registrado.',
        'contraseña.min' => 'La contraseña debe tener mínimo 6 caracteres.',
        'contraseña.confirmed' => 'Las contraseñas no coinciden.',
        'required' => 'El campo :attribute es obligatorio.',
        'email' => 'El campo :attribute debe ser un correo válido.'
    ]);

        DB::table('personas')->insert([
            'documento' => $request->documento,
            'id_tipo_documento' => $request->id_tipo_documento,
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'direccion' => $request->direccion,
            'telefono' => $request->telefono,
            'correo' => $request->correo,
            'contraseña' => Hash::make($request->contraseña),
            'id_rol' => 2
        ]);

        return redirect()->route('login')->with('success', 'Registro exitoso. Ahora inicia sesión.');

    }
}
