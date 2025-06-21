<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function showLogin()
    {
        return view('login'); // resources/views/login.blade.php
    }

    public function login(Request $request)
    {
        $correo = $request->input('username');
        $contraseña = $request->input('password');

        $usuario = DB::table('personas')->where('correo', $correo)->first();

        if ($usuario && Hash::check($contraseña, $usuario->contraseña)) {
        session(['usuario' => (array) $usuario, 'ultimo_acceso' => now()]);

        if ($usuario->id_rol == 1) {
            return redirect()->route('producto.index')->with('mensaje', 'Bienvenido');
        } elseif ($usuario->id_rol == 2) {
            return redirect()->route('inicio');
        } else {
            return redirect()->route('login')->with('error', 'Rol no autorizado');
        }
    }

        return redirect('login')->with('error', 'Correo o contraseña incorrectos');
    }

    public function logout()
    {
        session()->flush();
        return redirect('login');
    }
}
