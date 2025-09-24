<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;

class EnvioController extends Controller
{
    // Mostrar formulario de envío
    public function index()
    {
        return view('envio');
    }

    // Guardar selección de envío
    public function guardar(Request $request)
    {
        $request->validate([
            'tipo_entrega' => 'required|string', // tienda o domicilio
            'direccion'    => 'nullable|string',
            'info_adicional' => 'nullable|string',
        ]);

        // Guardamos valores consistentes en sesión
        $tipoEntrega = $request->tipo_entrega === 'tienda' ? 'tienda' : 'domicilio';
        $direccion = ($tipoEntrega === 'tienda') ? 'Tv 79 #68 Sur-98a' : $request->direccion;

        session([
            'envio' => [
                'tipo_entrega'   => $tipoEntrega,
                'direccion'      => $direccion,
                'info_adicional' => $request->info_adicional ?? '',
            ]
        ]);

        return redirect()->route('confirmacion.index');
    }

    // Confirmación de envío y cálculo de totales
    public function confirmacion()
    {
        $usuario = session('usuario');
        if (!$usuario) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión.');
        }

        $persona = Usuario::find($usuario['id_persona']);
        $envio = session('envio', []);
        $carrito = session('carrito', []);

        $detallesCarrito = [];
        $subtotal = 0;

        foreach ($carrito as $item) {
            $valor = $item['valor'] ?? 0;
            $totalItem = $valor * $item['cantidad'] * 1.19; // incluye IVA
            $detallesCarrito[] = [
                'nombre' => $item['nombre'],
                'talla' => $item['talla'],
                'color' => $item['color'],
                'cantidad' => $item['cantidad'],
                'valor' => $valor,
                'total' => $totalItem,
            ];
            $subtotal += $valor * $item['cantidad'];
        }
        $tipoEntrega = $envio['tipo_entrega'] ?? 'domicilio'; // tienda o domicilio
        $direccion   = $envio['direccion'] ?? ($tipoEntrega === 'tienda' ? 'Tv 79 #68 Sur-98a' : $usuario['direccion'] ?? 'No registrada');
        $infoAdicional = $envio['info_adicional'] ?? '';

        // Costo de envío
        $costoEnvio = ($tipoEntrega === 'tienda') ? 0 : (($subtotal * 1.19 >= 150000) ? 0 : 15000);
        $totalFinal = ($subtotal * 1.19) + $costoEnvio;

        return view('confirmacion', compact(
            'persona',
            'detallesCarrito',
            'subtotal',
            'costoEnvio',
            'totalFinal',
            'tipoEntrega',
            'direccion',
            'infoAdicional',
            'envio'
        ));
    }
}
