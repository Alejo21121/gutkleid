<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Talla extends Model
{
    protected $table = 'tallas';

    protected $fillable = [
        'id_producto',
        'talla',
        'cantidad',
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'id_producto');
    }
}
