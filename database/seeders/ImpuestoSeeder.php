<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ImpuestoSeeder extends Seeder
{
    public function run(): void
    {
            DB::table('impuestos')->insert([
            ['origen' => 'nacional',   'tasa' => 19.00],
            ['origen' => 'nacional',   'tasa' => 5.00],
            ['origen' => 'importado',  'tasa' => 10.00],
            ['origen' => 'importado',  'tasa' => 0.00],
        ]);
    }
}
