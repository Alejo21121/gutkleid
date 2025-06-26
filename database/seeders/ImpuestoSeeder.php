<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ImpuestoSeeder extends Seeder
{
    public function run()
    {
        DB::table('impuestos')->insert([
            ['tasa' => 0.19],
        ]);
    }
}