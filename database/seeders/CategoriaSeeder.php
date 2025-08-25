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
    ['nombre' => 'Buzos','genero' => 'unisex'],
    ['nombre' => 'Chaquetas','genero' => 'unisex'],
    ['nombre' => 'Ropa Casual','genero' => 'unisex'],
    ['nombre' => 'Faldas','genero' => 'mujer'],
    ['nombre' => 'Blusas','genero' => 'mujer'],
    ['nombre' => 'Calzados','genero' => 'unisex'],
    ['nombre' => 'Accesorios','genero' => 'unisex'],
    ['nombre' => 'Gorras','genero' => 'unisex'],
    ['nombre' => 'Ropa interior','genero' => 'unisex'],
    ['nombre' => 'Camisas','genero' => 'unisex'],
    ['nombre' => 'Traje de baño','genero' => 'unisex'],
    ['nombre' => 'Ropa Dormir','genero' => 'unisex'],
]);
     
    }
}

