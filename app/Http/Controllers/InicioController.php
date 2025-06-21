<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class InicioController extends Controller
{
    public function index(Request $request)
    {
        // Verifica la sesión
        $usuario = Session::get('usuario');
        $inactividad = 300;

        if ($usuario) {
            $ultimoTiempo = Session::get('tiempo');
            if ($ultimoTiempo && (time() - $ultimoTiempo > $inactividad)) {
                Session::flush();
                return redirect()->route('login')->with('expirada', true);
            }
            Session::put('tiempo', time());
        }

        return view('inicio', compact('usuario'));
    }
}
