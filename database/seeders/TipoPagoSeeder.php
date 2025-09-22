<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoPagoSeeder extends Seeder
{
    public function run()
    {
        DB::table('metodo_pagos')->insert([
            ['nombre' => 'Efectivo'],
            ['nombre' => 'Transferencia'],
        ]);
    }
}