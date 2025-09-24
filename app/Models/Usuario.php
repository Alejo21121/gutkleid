<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;

    protected $table = 'personas';
    protected $primaryKey = 'id_persona';
    public $timestamps = false;

    // Campos permitidos para asignación masiva, sin 'id_rol'
    protected $fillable = [
        'id_persona',
        'documento',
        'id_tipo_documento',
        'fecha_nacimiento',
        'nombres',
        'apellidos',
        'telefono',
        'correo',
        'contraseña',
        'direccion',
        'id_rol',
    ];


    protected $hidden = [
        'contraseña',
    ];


        public function tipoDocumento()
    {
        return $this->belongsTo(TipoDocumento::class, 'id_tipo_documento');
    }

        public function rol()
    {
        return $this->belongsTo(Rol::class, 'id_rol');
    }

}