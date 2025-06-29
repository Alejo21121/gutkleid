<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Producto;

class InicioController extends Controller
{
    public function index(Request $request)
    {
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

        // ✅ Traer productos con imágenes
        $productos = Producto::with('imagenes')->take(6)->get();

        return view('inicio', compact('usuario', 'productos'));
    }
}
