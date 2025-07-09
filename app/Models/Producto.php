<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Impuesto;


class Producto extends Model
{
    protected $table = 'productos'; // Muy importante

    protected $primaryKey = 'id_producto'; // Tu clave primaria personalizada
    public $incrementing = true; // Es lo predeterminado, pero lo puedes dejar explícito

    protected $fillable = [
        'id_producto', 'nombre', 'valor', 'marca', 'talla',
        'color', 'id_categoria', 'cantidad'
    ];

    public $timestamps = true; // Si tienes created_at y updated_at

        // Al final del modelo Producto
    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'id_categoria');
    }

        public function imagenes()
    {
        return $this->hasMany(Imagen::class, 'id_producto');
    }

        public function tallas()
    {
        return $this->hasMany(Talla::class, 'id_producto');
    }

}

