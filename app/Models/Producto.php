<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'productos'; // Muy importante

    protected $primaryKey = 'id_producto'; // Tu clave primaria personalizada

    protected $fillable = [
        'id_producto', 'nombre', 'valor', 'marca', 'talla',
        'color', 'categoria'
    ];

    public $timestamps = true; // Si tienes created_at y updated_at
}
