<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subcategoria extends Model
{
    protected $table = 'subcategorias'; // Nombre de la tabla

    protected $primaryKey = 'id_subcategoria'; // Clave primaria personalizada

    protected $fillable = [
        'nombre',
        'id_categoria'
    ];

    public $timestamps = true; // Usa created_at y updated_at

    // Relación: una subcategoría pertenece a una categoría
    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'id_categoria', 'id_categoria');
    }

    public function productos()
    {
        return $this->hasMany(Producto::class, 'id_subcategoria');
    }
}
