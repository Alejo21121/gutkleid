<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Producto;

class Imagen extends Model
{
    protected $table = 'imagenes';
    protected $primaryKey = 'id_imagen'; // 👈 Esto es lo más importante

    public $timestamps = false; // si no usas created_at / updated_at

    protected $fillable = ['id_producto', 'ruta'];

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'id_producto');
    }
}

