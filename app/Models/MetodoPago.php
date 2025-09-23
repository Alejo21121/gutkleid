<?php

// app/Models/MetodoPago.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MetodoPago extends Model
{
    protected $table = 'metodo_pagos';
    protected $primaryKey = 'id_metodo_pago';
    protected $fillable = ['nombre'];

    public function subMetodos()
    {
        return $this->hasMany(SubMetodoPago::class, 'id_metodo_pago');
    }
}

// app/Models/SubMetodoPago.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubMetodoPago extends Model
{
    protected $table = 'sub_metodos_pago';
    protected $primaryKey = 'id_sub_metodo';
    protected $fillable = ['id_metodo_pago', 'nombre'];

    public function metodoPago()
    {
        return $this->belongsTo(MetodoPago::class, 'id_metodo_pago');
    }
}
