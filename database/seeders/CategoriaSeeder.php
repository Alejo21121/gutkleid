<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriaSeeder extends Seeder
{
    public function run()
    {
          DB::table('categorias')->insert([
            'Pantalones', 
            'Abrigos',
            'Vestidos',
            'Ropa Casual',
            'Faldas',
            'Blusas',
            'Calzados',
            'Accesorios',
            'Gorras',
            'Ropa interior',
            'Camisas',
            'Traje de baño',
            'Ropa Dormir'
          ]);
     
    }
}
