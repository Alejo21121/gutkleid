<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
    protected $table = 'inventario'; // ya lo hiciste

    protected $primaryKey = 'id_inventario';

    // ✅ Agrega esta línea
    protected $fillable = [
        'stock',
        'fecha_salida',
        'precio_compras',
        'precio_ventas',
        'id_producto',
    ];
}
