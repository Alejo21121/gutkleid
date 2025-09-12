<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductoSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('productos')->insert([
            ['nombre' => 'Buzo',              'valor' => 90000, 'marca' => 'Rod Style', 'sexo' => 'Hombre',    'color' => 'Beige',     'id_categoria' => 2, 'id_subcategoria'=> null],
            ['nombre' => 'Jean Clásico',      'valor' => 59999, 'marca' => 'Huba',  'sexo' => 'Hombre',      'color' => 'Azul',      'id_categoria' => 1, 'id_subcategoria'=> 1],
            ['nombre' => 'Chaqueta Jean',     'valor' => 99999, 'marca' => 'Levítico', 'sexo' => 'Hombre',  'color' => 'Negro',     'id_categoria' => 3, 'id_subcategoria'=> null],
            ['nombre' => 'Buzo Capotero',     'valor' => 44999, 'marca' => 'Old school','sexo' => 'Mujer',   'color' => 'Verde',     'id_categoria' => 2, 'id_subcategoria'=> null],
            ['nombre' => 'Chaqueta acolchada', 'valor' => 44999, 'marca' => 'Dackos',  'sexo' => 'Mujer',      'color' => 'Azul',      'id_categoria' => 3, 'id_subcategoria'=> null],
            ['nombre' => 'Jean',              'valor' => 64999, 'marca' => 'Giotto',   'sexo' => 'Mujer',     'color' => 'Azul',      'id_categoria' => 1, 'id_subcategoria'=> 1],
            ['nombre' => 'Gorra',             'valor' => 24999, 'marca' => 'Generica',   'sexo' => 'Hombre',     'color' => 'Gris',      'id_categoria' => 4, 'id_subcategoria'=> null],
        ]);
    }
}
