<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class SubcategoriasSeeder extends Seeder
{
    public function run()
    {
          DB::table('subcategorias')->insert([
    ['nombre' => 'Jeans','id_categoria' => 1],
    ['nombre' => 'Drill','id_categoria' => 1],
    ['nombre' => 'Manga larga','id_categoria' => 5],
    ['nombre' => 'Manga corta','id_categoria' => 5],
]);
     
    }
}