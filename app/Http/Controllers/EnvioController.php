<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Config;

class EnvioController extends Controller
{
    // Mostrar formulario de envío
    public function index()
    {
        return view('envio');
    }


    // Confirmación de envío y preparación de pago Bold
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
        $totalFinal = 0;

        // **AQUÍ SE CALCULA $totalFinal**
        foreach ($carrito as $item) {
            $valor = $item['valor'] ?? 0;
            $totalItem = $valor * $item['cantidad'] * 1.19; // incluye IVA
            $detallesCarrito[] = [
                'nombre' => $item['nombre'],
                'talla' => $item['talla'],
                'color' => $item['color'],
                'cantidad' => $item['cantidad'],
                'total' => $totalItem,
            ];
            $totalFinal += $totalItem;
        }

        $costoEnvio = $totalFinal >= 150000 ? 0 : 15000;
        $totalFinal += $costoEnvio;

        // 🔹 Ahora que $totalFinal está definido, podemos usarlo para preparar los datos de Bold
        $orderId = uniqid('orden_'); // ID único de la orden
        
        $publicKey = Config::get('services.bold.api_key'); 
        $privateKey = Config::get('services.bold.private_key'); 

        $amountInCents = intval($totalFinal * 100); 
        $currency = 'COP';

        $integritySignature = hash_hmac(
            'sha256',
            $orderId . $amountInCents . $currency,
            $privateKey 
        );

        return view('confirmacion', compact(
            'persona',
            'envio',
            'detallesCarrito',
            'totalFinal',
            'orderId',
            'integritySignature',
            'amountInCents',
            'publicKey'
        ));
    }
}
