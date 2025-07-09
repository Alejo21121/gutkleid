<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductoSeeder extends Seeder
{
    public function run(): void
    {
            DB::table('productos')->insert([
        ['nombre' => 'Buzo',              'valor' => 64999, 'marca' => 'Generica',       'color' => 'Beige',     'id_categoria' => 2],
        ['nombre' => 'Jean Clásico',      'valor' => 59999, 'marca' => 'Generica',       'color' => 'Azul',      'id_categoria' => 1],
        ['nombre' => 'Chaqueta Jean',     'valor' => 99999, 'marca' => 'CITY Garments',  'color' => 'Negra',     'id_categoria' => 3],
        ['nombre' => 'Buzo Capotero',     'valor' => 44999, 'marca' => 'CITY Garments',  'color' => 'Verde',     'id_categoria' => 2],
        ['nombre' => 'Chaqueta acolchada','valor' => 44999, 'marca' => 'Generica',       'color' => 'Azul',      'id_categoria' => 3],
        ['nombre' => 'Jean',              'valor' => 64999, 'marca' => 'Generica',       'color' => 'Azul',      'id_categoria' => 1],
        ['nombre' => 'Gorra',             'valor' => 24999, 'marca' => 'Generica',       'color' => 'Gris',      'id_categoria' => 9],
    ]);

    }
}
