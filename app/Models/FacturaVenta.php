<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FacturaVenta;
use PDF; // Asegúrate de tener instalado barryvdh/laravel-dompdf

class FacturaController extends Controller
{
    // Generar PDF de la factura
    public function generarPDF($idFactura)
    {
        // Traemos la factura con todas las relaciones necesarias
        $factura = FacturaVenta::with([
            'cliente',               // Datos del cliente
            'detalles.producto',     // Productos
            'detalles.talla',        // Tallas
            'metodoPago',            // Método de pago
            'subMetodoPago'          // Submétodo o banco
        ])->findOrFail($idFactura);

        // Podemos calcular envío si quieres mostrarlo en PDF
        $costoEnvio = session('envio')['tipo_entrega'] === 'domicilio' 
                      ? 15000 
                      : 0; // ejemplo, ajusta según tus reglas
        $subtotalGeneral = 0;
        $ivaGeneral = 0;

        foreach ($factura->detalles as $detalle) {
            $valorUnitario = $detalle->producto->valor;
            $cantidad = $detalle->cantidad;
            $subtotal = $valorUnitario * $cantidad;
            $iva = round($subtotal * 0.19, 0);
            $subtotalGeneral += $subtotal;
            $ivaGeneral += $iva;
        }

        $totalFinal = $subtotalGeneral + $ivaGeneral + $costoEnvio;

        // Pasamos todos los datos a la vista
        $pdf = PDF::loadView('factura', [
            'factura' => $factura,
            'subtotalGeneral' => $subtotalGeneral,
            'ivaGeneral' => $ivaGeneral,
            'totalFinal' => $totalFinal,
            'costoEnvio' => $costoEnvio,
            'metodo_pago' => $factura->metodoPago->nombre ?? '—',
            'sub_metodo' => $factura->subMetodoPago->nombre ?? null,
        ]);

        return $pdf->stream('factura_'.$factura->id_factura_venta.'.pdf');
    }
}
