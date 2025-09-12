<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Talla extends Model
{
    protected $table = 'tallas';
    public $timestamps = true;

    protected $fillable = [
        'id_producto',
        'talla',
        'color',
        'cantidad',
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'id_producto');
    }
}