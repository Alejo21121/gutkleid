<?php

namespace App\Mail;

use App\Models\FacturaVenta;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FacturaMail extends Mailable
{
    use Queueable, SerializesModels;

    // Estas propiedades públicas quedan disponibles en la vista Blade
    public $factura;
    public $cliente;

    // Ruta del PDF a adjuntar
    protected $rutaPdf;

    public function __construct(FacturaVenta $factura, string $rutaPdf)
    {
        $this->factura = $factura;
        $this->cliente = $factura->cliente; // relación con Persona
        $this->rutaPdf = $rutaPdf;
    }

    public function build()
    {
        $nombreAdjunto = 'Factura_GutKleid_' . $this->factura->id_factura_venta . '.pdf';

        return $this->subject('Tu factura #' . $this->factura->id_factura_venta . ' - Gut Kleid')
            // Pasamos explícitamente las variables a la vista (opcional si son públicas, pero así es claro)
            ->markdown('emails.factura', [
                'factura' => $this->factura,
                'cliente' => $this->cliente,
            ])
            ->attach($this->rutaPdf, [
                'as' => $nombreAdjunto,
                'mime' => 'application/pdf',
            ]);
    }
}
