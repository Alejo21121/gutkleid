<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriaSeeder extends Seeder
{
    public function run()
    {
          DB::table('categorias')->insert([
    ['nombre' => 'Pantalones','genero' => 'unisex'],
    ['nombre' => 'Hoodie','genero' => 'unisex'],
    ['nombre' => 'Chaquetas','genero' => 'unisex'],
    ['nombre' => 'Gorras','genero' => 'unisex'],
    ['nombre' => 'Camisas','genero' => 'unisex'],
    ['nombre' => 'Camisetas','genero' => 'unisex'],
]);
     
    }
}

