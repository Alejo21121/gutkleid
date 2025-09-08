<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TallaSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('tallas')->insert([
            ['id_producto' => 1, 'talla' => 'XS', 'cantidad' => 10],
            ['id_producto' => 1, 'talla' => 'S', 'cantidad' => 10],
            ['id_producto' => 1, 'talla' => 'M', 'cantidad' => 10],
            ['id_producto' => 1, 'talla' => 'L', 'cantidad' => 10],

            ['id_producto' => 2, 'talla' => '28', 'cantidad' => 10],
            ['id_producto' => 2, 'talla' => '30', 'cantidad' => 10],
            ['id_producto' => 2, 'talla' => '32', 'cantidad' => 10],
            ['id_producto' => 2, 'talla' => '34', 'cantidad' => 10],
            
            ['id_producto' => 3, 'talla' => 'XS', 'cantidad' => 10],
            ['id_producto' => 3, 'talla' => 'S', 'cantidad' => 10],
            ['id_producto' => 3, 'talla' => 'M', 'cantidad' => 10],
            ['id_producto' => 3, 'talla' => 'L', 'cantidad' => 10],

            ['id_producto' => 4, 'talla' => 'XS', 'cantidad' => 10],
            ['id_producto' => 4, 'talla' => 'S', 'cantidad' => 10],
            ['id_producto' => 4, 'talla' => 'M', 'cantidad' => 10],
            ['id_producto' => 4, 'talla' => 'L', 'cantidad' => 10],

            ['id_producto' => 5, 'talla' => 'XS', 'cantidad' => 10],
            ['id_producto' => 5, 'talla' => 'S', 'cantidad' => 10],
            ['id_producto' => 5, 'talla' => 'M', 'cantidad' => 10],
            ['id_producto' => 5, 'talla' => 'L', 'cantidad' => 10],

            ['id_producto' => 6, 'talla' => '28', 'cantidad' => 10],
            ['id_producto' => 6, 'talla' => '30', 'cantidad' => 10],
            ['id_producto' => 6, 'talla' => '32', 'cantidad' => 10],
            ['id_producto' => 6, 'talla' => '34', 'cantidad' => 10],

            ['id_producto' => 7, 'talla' => 'U', 'cantidad' => 15],
        ]);
    }
}
