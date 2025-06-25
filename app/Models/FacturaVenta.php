<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FacturaVenta extends Model
{
    protected $table = 'factura_ventas';
    protected $primaryKey = 'id_factura_venta';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'nit_tienda',
        'dire_tienda',
        'telef_tienda',
        'fecha_venta', // ESTA es la correcta
        'total',
        'id_persona',
        'id_metodo_pago'
    ];
}
