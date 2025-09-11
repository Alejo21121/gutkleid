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

    // Guardar información de envío
    public function guardar(Request $request)
    {
        $request->validate([
            'tipo_entrega' => 'required|in:tienda,domicilio',
            'direccion' => 'nullable|string|max:255',
            'info_adicional' => 'nullable|string|max:500',
        ]);

        $usuario = session('usuario');
        if (!$usuario) return redirect()->route('login')->with('error', 'Debes iniciar sesión.');

        $direccion = $request->tipo_entrega === 'domicilio' ? $request->direccion : 'Tv 79 #68 Sur 98a';

        if ($request->tipo_entrega === 'domicilio') {
            Usuario::where('id_persona', $usuario['id_persona'])->update(['direccion' => $direccion]);
            $usuario['direccion'] = $direccion;
            session(['usuario' => $usuario]);
        }

        session(['envio' => [
            'tipo_entrega' => $request->tipo_entrega,
            'direccion' => $direccion,
            'info_adicional' => $request->info_adicional,
        ]]);

        return redirect()->route('envio.confirmacion');
    }

    // Confirmación de envío y preparación de pago Bold
// EnvioController.php

// ...

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