<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MetodoPago;
use App\Models\SubMetodoPago;

class MetodoPagoController extends Controller
{
    // Muestra el formulario con los métodos de pago
    public function index()
    {
        $metodos = MetodoPago::all(); // 🔹 sin submetodos
        return view('metodo_pago', compact('metodos'));
    }

    // Guarda la selección del usuario y redirige a confirmación
    public function store(Request $request)
    {
        $request->validate([
            'metodo_pago' => 'required|string',
            'banco'       => 'nullable|string',
            'direccion'   => 'nullable|string',      // desde formulario de envío
            'info_adicional' => 'nullable|string',  // desde formulario de envío
        ]);

        // Guardar todo en sesión
        session([
            'metodo_pago'     => $request->metodo_pago,
            'banco'           => $request->banco,
            'direccion'       => $request->direccion,
            'info_adicional'  => $request->info_adicional,
        ]);

        // Redirigir a la vista de confirmación
        return redirect()->route('metodo_pago.confirmacion');
    }

public function confirmacion(Request $request)
{
    // Datos del pago
    $metodo_pago = session('metodo_pago', '—');
    $banco = session('banco', '—');

    // Datos del envío
    $envio = session('envio', []);
    $tipoEntrega = $envio['tipo_entrega'] ?? 'tienda';
    $direccionMostrada = $envio['direccion'] ?? ($tipoEntrega === 'tienda' ? 'Tv 79 #68 Sur 98a' : '');
    $infoAdicional = $envio['info_adicional'] ?? '';

    // Datos del usuario desde sesión
    $persona = session('usuario'); // id, nombres, correo, telefono, etc.

    // Carrito
    $detallesCarrito = session('carrito', []);
    $subtotal = array_sum(array_map(fn($item) => $item['valor'] * $item['cantidad'], $detallesCarrito));
    $ivaTotal = $subtotal * 0.19;
    $totalFinal = $subtotal + $ivaTotal;

    // Costo de envío: gratis si subtotal >= 150k
    $costoEnvio = $subtotal >= 150000 ? 0 : 15000;
    $totalFinal += $costoEnvio;

    return view('confirmacion', compact(
        'metodo_pago',
        'banco',
        'persona',
        'detallesCarrito',
        'subtotal',
        'ivaTotal',
        'totalFinal',
        'costoEnvio',
        'direccionMostrada',
        'infoAdicional',
        'tipoEntrega'
    ));
}
}