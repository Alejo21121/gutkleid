<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetalleCompra extends Model
{
    protected $table = 'detalles_compras';
    protected $primaryKey = 'id_detalle';
    public $timestamps = true;

    protected $fillable = [
        'id_factura_compras', 'id_producto', 'valor_unitario', 'total'
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'id_producto');
    }

    public function factura()
    {
        return $this->belongsTo(FacturaCompra::class, 'id_factura_compras');
    }
}
