<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BienvenidaMail extends Mailable
{
    use Queueable, SerializesModels;

    public $nombre; // variable disponible en la vista Blade

    public function __construct($usuario)
    {
        // Aseguramos acceso por objeto
        $this->nombre = $usuario->nombres ?? 'Usuario';
    }

    public function build()
    {
        return $this->subject('¡Bienvenido a Gut Kleid!')
                    ->view('emails.bienvenida')
                    ->with([
                        'nombre' => $this->nombre, // usamos la propiedad correcta
                    ]);
    }
}
