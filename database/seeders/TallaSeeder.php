<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TallaSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('tallas')->insert([
            ['id_producto' => 1, 'talla' => 'S', 'cantidad' => 9],
            ['id_producto' => 1, 'talla' => 'M', 'cantidad' => 10],
            ['id_producto' => 1, 'talla' => 'L', 'cantidad' => 19],

            ['id_producto' => 2, 'talla' => '30', 'cantidad' => 7],
            ['id_producto' => 2, 'talla' => '32', 'cantidad' => 6],

            ['id_producto' => 3, 'talla' => 'M', 'cantidad' => 8],

            ['id_producto' => 4, 'talla' => 'S', 'cantidad' => 5],
            ['id_producto' => 4, 'talla' => 'M', 'cantidad' => 5],

            ['id_producto' => 5, 'talla' => 'L', 'cantidad' => 4],

            ['id_producto' => 6, 'talla' => '34', 'cantidad' => 10],

            ['id_producto' => 7, 'talla' => 'U', 'cantidad' => 12],
        ]);
    }
}
