<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\DB; 

class EnvioController extends Controller
{
    public function index()
    {
        return view('envio');
    }

    public function guardar(Request $request)
    {
        $request->validate([
            'tipo_entrega' => 'required|in:tienda,domicilio',
            'direccion' => 'nullable|string|max:255',
        ]);

        $usuario = session('usuario');

        if (!$usuario) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión.');
        }

        if ($request->tipo_entrega === 'domicilio') {
            // Dirección viene del formulario
            $direccion = $request->direccion;

            // Actualizar en la base de datos
            Usuario::where('id_persona', $usuario['id_persona'])
                ->update(['direccion' => $direccion]);

            // Refrescar la sesión del usuario con la nueva dirección
            $usuario['direccion'] = $direccion;
            session(['usuario' => $usuario]);

        } else {
            // Si recoge en tienda, usar dirección fija
            $direccion = 'Tv 79 #68 Sur 98a';
        }

        // Guardar en sesión los datos del envío
        session([
            'envio' => [
                'tipo_entrega' => $request->tipo_entrega,
                'direccion' => $direccion,
            ]
        ]);

        // Redirigir a la confirmación
        return redirect()->route('envio.confirmacion');
    }

    public function confirmacion()
    {
        $usuario = session('usuario');

        if (!$usuario) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión.');
        }

        // Datos de la persona desde DB (sin mostrar la dirección aquí)
        $persona = DB::table('personas')
            ->select('documento', 'fecha_nacimiento', 'nombres', 'apellidos', 'correo', 'telefono', 'info_adicional')
            ->where('id_persona', $usuario['id_persona'])
            ->first();

        // Datos de envío desde la sesión (contienen la dirección seleccionada)
        $envio = session('envio');

        return view('confirmacion', compact('persona', 'envio'));
    }
}
