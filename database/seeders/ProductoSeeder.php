<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductoSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('productos')->insert([
            ['nombre' => 'Buzo',             'valor' => 64999, 'marca' => 'Generica',        'talla' => 'M',  'color' => 'Beige',     'id_categoria' => 2, 'cantidad' => 10],
            ['nombre' => 'Jean Clasico',     'valor' => 59999, 'marca' => 'Generica',        'talla' => '32', 'color' => 'Azul',          'id_categoria' => 1, 'cantidad' => 10],
            ['nombre' => 'Chaqueta Jean',    'valor' => 99999,'marca' => 'CITY Garments',   'talla' => 'M',  'color' => 'Negra',          'id_categoria' => 3, 'cantidad' => 10],
            ['nombre' => 'Buzo Capotero',    'valor' => 44999, 'marca' => 'CITY Garments',   'talla' => 'M',  'color' => 'Verde','id_categoria' => 2, 'cantidad' => 10],
            ['nombre' => 'Chaqueta acolchada',         'valor' => 44999, 'marca' => 'Generica',        'talla' => 'L',  'color' => 'Azul',    'id_categoria' => 3, 'cantidad' => 10],
            ['nombre' => 'Jean',             'valor' => 64999, 'marca' => 'Generica',        'talla' => '34', 'color' => 'Azul',     'id_categoria' => 1, 'cantidad' => 10],
            ['nombre' => 'Gorra',            'valor' => 24999, 'marca' => 'Generica',        'talla' => 'U',  'color' => 'Gris',    'id_categoria' => 9, 'cantidad' => 10],
        ]);
    }
}
