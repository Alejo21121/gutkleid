<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    protected $table = 'personas'; // 👈 le dices a Laravel que use esta tabla

    protected $primaryKey = 'id_persona'; // 👈 si tu clave primaria no es "id"

    public $timestamps = false; // 👈 si tu tabla no tiene 'created_at' y 'updated_at'

    protected $fillable = [
        'documento',
        'id_tipo_documento',
        'fecha_nacimiento',
        'nombres',
        'apellidos',
        'correo',
        'telefono',
        'direccion',
        'info_adicional',
        'imagen',
        'id_rol'
    ];
}
