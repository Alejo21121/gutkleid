<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProveedoresSeeder extends Seeder
{
    public function run(): void
    {
        $proveedores = [
            // JEANS HOMBRE
            ['nombre' => 'Huba', 'telefono' => '3000000001', 'correo' => 'huba@proveedor.com', 'direccion' => 'Calle 1 #10-20'],
            ['nombre' => 'Gasolina', 'telefono' => '3000000002', 'correo' => 'gasolina@proveedor.com', 'direccion' => 'Calle 2 #11-21'],
            ['nombre' => 'Deniks', 'telefono' => '3000000003', 'correo' => 'deniks@proveedor.com', 'direccion' => 'Calle 3 #12-22'],

            // JEANS MUJER
            ['nombre' => 'Ccori', 'telefono' => '3000000004', 'correo' => 'ccori@proveedor.com', 'direccion' => 'Calle 4 #13-23'],
            ['nombre' => 'Giotto', 'telefono' => '3000000005', 'correo' => 'giotto@proveedor.com', 'direccion' => 'Calle 5 #14-24'],

            // CHAQUETAS HOMBRE
            ['nombre' => 'Strong', 'telefono' => '3000000006', 'correo' => 'strong@proveedor.com', 'direccion' => 'Calle 6 #15-25'],
            ['nombre' => 'Levítico', 'telefono' => '3000000007', 'correo' => 'levitico@proveedor.com', 'direccion' => 'Calle 7 #16-26'],

            // CHAQUETAS MUJER
            ['nombre' => 'Dackos', 'telefono' => '3000000008', 'correo' => 'dackos@proveedor.com', 'direccion' => 'Calle 8 #17-27'],
            ['nombre' => 'Lebefy', 'telefono' => '3000000009', 'correo' => 'lebefy@proveedor.com', 'direccion' => 'Calle 9 #18-28'],

            // BUZOS MUJER
            ['nombre' => 'Old school', 'telefono' => '3000000010', 'correo' => 'oldschool@proveedor.com', 'direccion' => 'Calle 10 #19-29'],
            ['nombre' => 'Kott risk', 'telefono' => '3000000011', 'correo' => 'kottrisk@proveedor.com', 'direccion' => 'Calle 11 #20-30'],

            // BUZOS HOMBRE
            ['nombre' => 'Rod Style', 'telefono' => '3000000012', 'correo' => 'rodstyle@proveedor.com', 'direccion' => 'Calle 12 #21-31'],
            ['nombre' => 'Laguna beach', 'telefono' => '3000000013', 'correo' => 'laguna@proveedor.com', 'direccion' => 'Calle 13 #22-32'],

            // CAMISETAS
            ['nombre' => 'Petro azul', 'telefono' => '3000000014', 'correo' => 'petroazul@proveedor.com', 'direccion' => 'Calle 14 #23-33'],
            ['nombre' => 'Generica', 'telefono' => '3000000015', 'correo' => 'generica@proveedor.com', 'direccion' => 'Calle 15 #24-34'],
        ];

        foreach ($proveedores as $proveedor) {
            DB::table('proveedors')->insert([
                ...$proveedor,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
