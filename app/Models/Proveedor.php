<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    // Laravel cree que la tabla se llama "proveedors" en plural sería "proveedores", pero tú usas "proveedors"
    protected $table = 'proveedors';

    protected $primaryKey = 'id_proveedor';

    protected $fillable = [
        'nombre', 'nit', 'direccion', 'telefono', 'email'
    ];

    public $timestamps = true;
}
