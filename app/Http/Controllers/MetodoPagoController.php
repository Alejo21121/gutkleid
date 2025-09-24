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
            'info_adicional' => 'nullable|string',
            'tipo_entrega' => 'nullable|string', // recoger en tienda o domicilio  // desde formulario de envío
        ]);

        // Dirección depende del tipo de entrega
        $direccion = $request->tipo_entrega === 'tienda'
            ? 'Recoger en tienda - Gut Kleid'
            : $request->direccion;

        // Guardar todo en sesión
        session([
            'metodo_pago'    => $request->metodo_pago,
            'banco'          => $request->banco,
            'direccion'      => $direccion,
            'info_adicional' => $request->info_adicional,
            'tipo_entrega'   => $request->tipo_entrega,
        ]);
        // Redirigir a la vista de confirmación
        return redirect()->route('metodo_pago.confirmacion');
    }
    public function confirmacion()
    {
        // 🟢 Persona y datos de envío
        $persona = session('persona', []);
        $envio   = session('envio', []);

        // 🟢 Carrito y totales
        $detallesCarrito = session('carrito', []);
        $subtotal   = session('subtotal', 0);
        $ivaTotal   = session('ivaTotal', 0);
        $costoEnvio = session('costoEnvio', 0);
        $totalFinal = session('totalFinal', 0);

        // 🟢 Variables de transacción (si hay pasarela de pago)
        $orderId            = session('orderId');
        $integritySignature = session('integritySignature');
        $amountInCents      = session('amountInCents');
        $publicKey          = session('publicKey');

        // 🟢 Método de pago (se guardan al elegirlo en la vista de método de pago)
        $idMetodo = session('metodo_pago');
        $idBanco  = session('banco');
        $direccion  = $envio['direccion'] ?? '';
        $tipoEntrega = $envio['tipo_entrega'] ?? '—';
        $infoAdicional = $envio['info_adicional'] ?? '';


        // Si es numérico, buscar en BD; si no, usar el texto directamente
        if (is_numeric($idMetodo)) {
            $metodo_pago = MetodoPago::find($idMetodo)->nombre ?? $idMetodo;
        } else {
            $metodo_pago = $idMetodo; // Efectivo, Transferencia, etc.
        }

        $banco = $idBanco ?? '';

        // 🟢 Retornar a la vista con TODA la información
        return view('confirmacion', compact(
            'persona',
            'envio',
            'detallesCarrito',
            'subtotal',
            'ivaTotal',
            'costoEnvio',
            'totalFinal',
            'orderId',
            'integritySignature',
            'amountInCents',
            'publicKey',
            'metodo_pago',
            'banco',
            'direccion',
            'infoAdicional',
            'tipoEntrega'
        ));
    }
}
