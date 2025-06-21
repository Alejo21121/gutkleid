<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;

class PersonaSeeder extends Seeder
{
    public function run()
    {
        DB::table('personas')->insert([
            'documento' => '1012331501',
            'id_tipo_documento' => 1, // Asegúrate de que exista este ID en la tabla tipo_documento
            'nombres' => 'Juan David',
            'apellidos' => 'Benitez Corredor',
            'correo' => 'juanbenitez17032005@gmail.com',
            'contraseña' => Hash::make('Cobi1109#'), // Siempre usa hash para contraseñas
            'telefono' => '3042255701',
            'direccion' => 'cra 81i #73f-63 sur',
            'id_rol' => 1, // Asegúrate de que este rol exista en la tabla roles
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
