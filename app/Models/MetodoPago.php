<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MetodoPago extends Model
{
    protected $table = 'metodo_pagos';
    protected $primaryKey = 'id_metodo_pago'; // 👈 Esta línea es vital
    public $timestamps = true;
}
