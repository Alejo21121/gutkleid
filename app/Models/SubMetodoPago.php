<?php

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