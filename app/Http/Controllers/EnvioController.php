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
            $cantidad = $item['cantidad'] ?? 1;

            $detallesCarrito[] = [
                'nombre'   => $item['nombre'],
                'talla'    => $item['talla'],
                'color'    => $item['color'],
                'cantidad' => $cantidad,
                'valor'    => $valor,
                'total'    => $valor * $cantidad, // sin IVA
            ];

            $subtotal += $valor * $cantidad;
        }

        // IVA = 19% del subtotal
        $ivaTotal = $subtotal * 0.19;

        // Subtotal con IVA
        $subtotalConIva = $subtotal + $ivaTotal;

        $tipoEntrega = $envio['tipo_entrega'] ?? 'domicilio';
        $direccion   = $envio['direccion'] ?? ($tipoEntrega === 'tienda' ? 'Tv 79 #68 Sur-98a' : $usuario['direccion'] ?? 'No registrada');
        $infoAdicional = $envio['info_adicional'] ?? '';

        // Costo de envío (gratis si >= 150k)
        $costoEnvio = ($tipoEntrega === 'tienda') ? 0 : (($subtotalConIva >= 150000) ? 0 : 15000);

        // Valor final a pagar
        $totalFinal = $subtotalConIva + $costoEnvio;

        return view('confirmacion', compact(
            'persona',
            'detallesCarrito',
            'subtotal',
            'ivaTotal',
            'subtotalConIva',
            'costoEnvio',
            'totalFinal',
            'tipoEntrega',
            'direccion',
            'infoAdicional',
            'envio'
        ));
    }
}
