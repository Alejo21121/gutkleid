<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class RegistroController extends Controller
{

    public function mostrarFormulario() {
        $tipos = DB::table('tipo_documentos')->get(); 
        return view('registro', compact('tipos'));  
    }

    public function registrar(Request $request) {
    
    $request->validate([
        'documento' => 'required',
        'id_tipo_documento' => 'required',
        'nombres' => 'required|regex:/^[\pL\s]+$/u',
        'apellidos' => 'required|regex:/^[\pL\s]+$/u',
        'direccion' => 'required',
        'telefono' => 'required|numeric|digits_between:10,10',
        'correo' => 'required|email|unique:personas,correo',
        'contraseña' => [
            'required',
            'string',
            'min:8',
            'regex:/^(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/'],
        'fecha_nacimiento' => ['required', 'date', function ($attribute, $value, $fail) {
        $edad = \Carbon\Carbon::parse($value)->age;
        if ($edad < 18) {
            $fail('Debes tener al menos 18 años para registrarte.');
        }
    }]
    ], [
        'correo.unique' => 'El correo ya está registrado',
        'contraseña.min' => 'La contraseña debe tener al menos 8 caracteres',
        'contraseña.regex' => 'La contraseña debe tener al menos una mayúscula, un número y un carácter especial',
        'contraseña.confirmed' => 'Las contraseñas no coinciden.',
        'required' => 'El campo :attribute es obligatorio.',
        'email' => 'El campo :attribute debe ser un correo válido.',
        'nombres.regex' => 'El campo nombres solo puede contener letras',
        'apellidos.regex' => 'El campo apellidos solo puede contener letras ',
        'telefono.digits' => 'El número de teléfono debe tener 10 numeros exactamente',
        'telefono.numeric'  => 'El teléfono solo debe tener números.'
    ]);

        DB::table('personas')->insert([
            'documento' => $request->documento,
            'id_tipo_documento' => $request->id_tipo_documento,
            'fecha_nacimiento' => $request['fecha_nacimiento'],
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
