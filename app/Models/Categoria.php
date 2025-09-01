<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $table = 'categorias'; // Nombre de la tabla

    protected $primaryKey = 'id_categoria'; // Clave primaria personalizada

    protected $fillable = [
        'nombre', 'genero'
    ];

    public $timestamps = true; // Usa created_at y updated_at

    // Relación: una categoría tiene muchas subcategorías
    public function subcategorias()
    {
        return $this->hasMany(Subcategoria::class, 'id_categoria', 'id_categoria');
    }

    // Relación: una categoría tiene muchos productos
    public function productos()
    {
        return $this->hasMany(Producto::class, 'id_categoria', 'id_categoria');
    }
}
