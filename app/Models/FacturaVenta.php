<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FacturaVenta extends Model
{
    protected $table = 'factura_ventas';
    protected $primaryKey = 'id_factura_venta';
    public $timestamps = true;

    protected $fillable = [
        'nit_tienda',
        'dire_tienda',
        'telef_tienda',
        'fecha_venta',
        'total',
        'id_persona',
        'id_metodo_pago',
        'id_sub_metodo',
        'envio',
        'info_adicional'
    ];

    public function detalles()
    {
        return $this->hasMany(DetalleFacturaV::class, 'id_factura_venta');
    }

    public function cliente()
    {
        return $this->belongsTo(Persona::class, 'id_persona');
    }

    public function metodoPago()
    {
        return $this->belongsTo(MetodoPago::class, 'id_metodo_pago');
    }

    public function subMetodoPago()
    {
        return $this->belongsTo(SubMetodoPago::class, 'id_sub_metodo');
    }
}

