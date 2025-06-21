<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoDocumentoSeeder extends Seeder
{
    public function run()
    {
        DB::table('tipo_documentos')->insert([
            ['nombre' => 'Cédula de ciudadanía'],
            ['nombre' => 'Tarjeta de identidad'],
            ['nombre' => 'Cédula de extranjería'],
            ['nombre' => 'Pasaporte'],
        ]);
    }
}