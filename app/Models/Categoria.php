<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $table = 'categorias'; // Asegúrate de que el nombre coincida con tu tabla real

    protected $primaryKey = 'id_categoria'; // Tu clave primaria personalizada

    protected $fillable = [
        'id_categoria', 'nombre', 'genero'

    ];

    public $timestamps = true; // Si tienes created_at y updated_at

    // Relación: una categoría tiene muchos productos
    public function productos()
    {
        return $this->hasMany(Producto::class, 'id_categoria');
    }
}
