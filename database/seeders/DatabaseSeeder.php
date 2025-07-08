<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
   public function run(): void
{
    $this->call([
        TipoDocumentoSeeder::class,
        CategoriaSeeder::class,
        RolSeeder::class,
        ImpuestoSeeder::class,
        PersonaSeeder::class,
        ProductoSeeder::class,
        TipoPagoSeeder::class,
        ImagenSeeder::class,
        TallaSeeder::class
    ]);
}
}
