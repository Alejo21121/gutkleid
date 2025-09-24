<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        // Si usas Auth::user()
        if (auth()->check() && auth()->user()->id_rol == $role) {
            return $next($request);
        }

        // Si usas session('usuario')
        if (session()->has('usuario') && session('usuario')['id_rol'] == $role) {
            return $next($request);
        }

        // Si no tiene el rol → redirige al inicio
        return redirect()->route('inicio')->with('error', 'No tienes permiso para acceder a esta página.');
    }
}
