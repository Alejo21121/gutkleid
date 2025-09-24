<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MetodoPago;

class MetodoPagoController extends Controller
{
    // Muestra el formulario con los métodos de pago
    public function index()
    {
        $metodos = MetodoPago::all(); // 🔹 sin submétodos
        return view('metodo_pago', compact('metodos'));
    }

    // Guarda la selección del usuario y redirige a confirmación
    public function store(Request $request)
    {
        $request->validate([
            'metodo_pago' => 'required|string',
            'banco'       => 'nullable|string',
        ]);

        // Tomamos tipo_entrega y dirección desde sesión de envío
        $envio = session('envio', []);
        $tipoEntrega = $envio['tipo_entrega'] ?? 'domicilio';
        $direccion = $envio['direccion'] ?? ($tipoEntrega === 'tienda' ? 'Tv 79 #68 Sur-98a' : '');

        session([
            'metodo_pago'     => $request->metodo_pago,
            'sub_metodo_pago' => $request->banco,
            'tipo_entrega'    => $tipoEntrega,
            'direccion'       => $direccion,
            'info_adicional'  => $envio['info_adicional'] ?? '',
        ]);

        return redirect()->route('metodo_pago.confirmacion');
    }


    public function confirmacion()
    {
        $persona = session('persona', []);
        $envio   = session('envio', []);

        $detallesCarrito = session('carrito', []);
        $subtotal   = session('subtotal', 0);
        $ivaTotal   = session('ivaTotal', 0);
        $costoEnvio = session('costoEnvio', 0);
        $totalFinal = session('totalFinal', 0);

        $idMetodo = session('metodo_pago');
        $subMetodo = session('sub_metodo_pago');
        $direccion  = $envio['direccion'] ?? '';
        $tipoEntregaRaw = $envio['tipo_entrega'] ?? '—';
        $infoAdicional = $envio['info_adicional'] ?? '';

        $tipoEntrega = match ($tipoEntregaRaw) {
            'tienda' => 'Recoger en tienda',
            'domicilio' => 'Domicilio',
            default => $tipoEntregaRaw
        };

        if (is_numeric($idMetodo)) {
            $metodo_pago = MetodoPago::find($idMetodo)->nombre ?? $idMetodo;
        } else {
            $metodo_pago = $idMetodo;
        }

        return view('confirmacion', compact(
            'persona',
            'detallesCarrito',
            'subtotal',
            'ivaTotal',
            'costoEnvio',
            'totalFinal',
            'metodo_pago',
            'subMetodo',
            'direccion',
            'infoAdicional',
            'tipoEntrega'
        ));
    }
}
