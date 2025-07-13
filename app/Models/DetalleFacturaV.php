<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetalleFacturaV extends Model
{
    protected $table = 'detalles_factura_v_s'; // Asegúrate de que sea el nombre correcto de la tabla
    protected $primaryKey = 'id'; // o 'id_detalle', si ese es el nombre real

    protected $fillable = [
        'id_factura_venta', 'id_producto', 'cantidad', 'valor'
    ];

    public $timestamps = true; // o false si tu tabla no tiene created_at/updated_at
    public function producto()
{
    return $this->belongsTo(\App\Models\Producto::class, 'id_producto');
}

public function talla()
{
    return $this->belongsTo(Talla::class, 'id_talla');
}

}
