<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductoSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('productos')->insert([
            ['nombre' => 'Pantalón Jeans Slim Fit', 'valor' => 75000, 'marca' => 'DenimStyle', 'talla' => '32', 'color' => 'Azul Oscuro', 'id_categoria' => 1, 'cantidad' => 15],
            ['nombre' => 'Chaqueta Impermeable', 'valor' => 120000, 'marca' => 'AdventureGear', 'talla' => 'L', 'color' => 'Negro', 'id_categoria' => 2, 'cantidad' => 8],
            ['nombre' => 'Vestido Verano Floral', 'valor' => 60000, 'marca' => 'ChicDress', 'talla' => 'S', 'color' => 'Floral Multicolor', 'id_categoria' => 3, 'cantidad' => 12],
            ['nombre' => 'Sudadera con Capucha', 'valor' => 45000, 'marca' => 'UrbanFlex', 'talla' => 'XL', 'color' => 'Gris', 'id_categoria' => 4, 'cantidad' => 9],
            ['nombre' => 'Falda Midi Plisada', 'valor' => 55000, 'marca' => 'ElegantLook', 'talla' => 'M', 'color' => 'Verde Esmeralda', 'id_categoria' => 5, 'cantidad' => 7],
            ['nombre' => 'Blusa Seda Estampada', 'valor' => 70000, 'marca' => 'Fashionista', 'talla' => 'S', 'color' => 'Crema con Patrón', 'id_categoria' => 6, 'cantidad' => 6],
            ['nombre' => 'Zapatos Deportivos', 'valor' => 95000, 'marca' => 'RunFast', 'talla' => '40', 'color' => 'Azul Marino', 'id_categoria' => 7, 'cantidad' => 10],
            ['nombre' => 'Cinturón Cuero Clásico', 'valor' => 30000, 'marca' => 'AccesoriosTop', 'talla' => '90cm', 'color' => 'Marrón', 'id_categoria' => 8, 'cantidad' => 13],
            ['nombre' => 'Gorra de Béisbol', 'valor' => 18000, 'marca' => 'SportCap', 'talla' => 'Única', 'color' => 'Negro', 'id_categoria' => 9, 'cantidad' => 20],
            ['nombre' => 'Calcetines Tobilleros x3', 'valor' => 10000, 'marca' => 'ComfortFeet', 'talla' => 'L', 'color' => 'Variado', 'id_categoria' => 10, 'cantidad' => 25],
            ['nombre' => 'Chaqueta de Cuero Moto', 'valor' => 250000, 'marca' => 'BikerStyle', 'talla' => 'M', 'color' => 'Negro', 'id_categoria' => 2, 'cantidad' => 5],
            ['nombre' => 'Polo Piqué Algodón', 'valor' => 38000, 'marca' => 'ClassicWear', 'talla' => 'L', 'color' => 'Azul Claro', 'id_categoria' => 11, 'cantidad' => 8],
            ['nombre' => 'Shorts Deportivos', 'valor' => 30000, 'marca' => 'ActiveLife', 'talla' => 'S', 'color' => 'Negro', 'id_categoria' => 1, 'cantidad' => 11],
            ['nombre' => 'Bufanda de Lana', 'valor' => 22000, 'marca' => 'WinterWarmth', 'talla' => 'Única', 'color' => 'Rojo', 'id_categoria' => 8, 'cantidad' => 17],
            ['nombre' => 'Suéter de Punto Delgado', 'valor' => 50000, 'marca' => 'CozyKnit', 'talla' => 'M', 'color' => 'Beige', 'id_categoria' => 2, 'cantidad' => 6],
            ['nombre' => 'Bikini Floral', 'valor' => 40000, 'marca' => 'BeachDays', 'talla' => 'S', 'color' => 'Rosa Floral', 'id_categoria' => 12, 'cantidad' => 9],
            ['nombre' => 'Pijama Algodón', 'valor' => 35000, 'marca' => 'SweetDreams', 'talla' => 'M', 'color' => 'Rayas Azules', 'id_categoria' => 13, 'cantidad' => 7],
            ['nombre' => 'Zapatillas Casuales', 'valor' => 90000, 'marca' => 'UrbanWalk', 'talla' => '38', 'color' => 'Blanco', 'id_categoria' => 7, 'cantidad' => 10],
            ['nombre' => 'Guantes de Cuero', 'valor' => 42000, 'marca' => 'WinterEssentials', 'talla' => 'M', 'color' => 'Marrón Oscuro', 'id_categoria' => 8, 'cantidad' => 14],
            ['nombre' => 'Camiseta', 'valor' => 25000, 'marca' => 'Nike', 'talla' => 'M', 'color' => 'Negra', 'id_categoria' => 11, 'cantidad' => 16],
        ]);
    }
}
