<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetalleFacturaV extends Model
{
    protected $table = 'detalles_factura_v_s';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'id_factura_venta', 
        'id_producto', 
        'id_talla', // Clave foránea para la talla específica
        'cantidad', 
        'subtotal'
    ];

    public function factura()
    {
        return $this->belongsTo(FacturaVenta::class, 'id_factura_venta');
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'id_producto');
    }

    public function talla()
    {
        return $this->belongsTo(Talla::class, 'id_talla');
    }
}