<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FacturaCompra extends Model
{
    protected $table = 'factura_compras';
    protected $primaryKey = 'id_factura_compras';
    public $timestamps = true;

    protected $fillable = [
        'valor', 'fecha_compra', 'estado', 'id_inventario', 'id_proveedor'
    ];

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'id_proveedor');
    }

    public function detalles()
    {
        return $this->hasMany(DetalleCompra::class, 'id_factura_compras');
    }

    public function inventario()
    {
        return $this->belongsTo(Inventario::class, 'id_inventario');
    }
}
