<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Envio extends Model
{
    use HasFactory;

    protected $table = 'envios'; // asegúrate que la tabla en la migración sea 'envios'

    protected $fillable = [
        'id_usuario',
        'tipo_entrega',
        'direccion'
    ];

    public function usuario()
    {
        return $this->belongsTo(Persona::class, 'id_usuario', 'id_persona');
    }
}
