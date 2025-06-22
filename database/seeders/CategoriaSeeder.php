<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriaSeeder extends Seeder
{
    public function run()
    {
          DB::table('categorias')->insert([
    ['nombre' => 'Pantalones'],
    ['nombre' => 'Abrigos'],
    ['nombre' => 'Vestidos'],
    ['nombre' => 'Ropa Casual'],
    ['nombre' => 'Faldas'],
    ['nombre' => 'Blusas'],
    ['nombre' => 'Calzados'],
    ['nombre' => 'Accesorios'],
    ['nombre' => 'Gorras'],
    ['nombre' => 'Ropa interior'],
    ['nombre' => 'Camisas'],
    ['nombre' => 'Traje de baño'],
    ['nombre' => 'Ropa Dormir'],
]);
     
    }
}
