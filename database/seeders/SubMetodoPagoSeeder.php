<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubMetodoPagoSeeder extends Seeder
{
    public function run()
    {
        DB::table('sub_metodos_pago')->insert([
            ['id_metodo_pago' => 2, 'nombre' => 'Nequi'],
            ['id_metodo_pago' => 2, 'nombre' => 'Daviplata'],
            ['id_metodo_pago' => 2, 'nombre' => 'Dale'],
            ['id_metodo_pago' => 2, 'nombre' => 'Nu'],
        ]);
    }
}
