<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductoSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('productos')->insert([
            ['nombre' => 'Pantalón Jeans Slim Fit', 'valor' => 75000, 'marca' => 'DenimStyle', 'talla' => '32', 'color' => 'Azul Oscuro', 'categoria' => 'Pantalones'],
            ['nombre' => 'Chaqueta Impermeable', 'valor' => 120000, 'marca' => 'AdventureGear', 'talla' => 'L', 'color' => 'Negro', 'categoria' => 'Abrigos'],
            ['nombre' => 'Vestido Verano Floral', 'valor' => 60000, 'marca' => 'ChicDress', 'talla' => 'S', 'color' => 'Floral Multicolor', 'categoria' => 'Vestidos'],
            ['nombre' => 'Sudadera con Capucha', 'valor' => 45000, 'marca' => 'UrbanFlex', 'talla' => 'XL', 'color' => 'Gris', 'categoria' => 'Ropa Casual'],
            ['nombre' => 'Falda Midi Plisada', 'valor' => 55000, 'marca' => 'ElegantLook', 'talla' => 'M', 'color' => 'Verde Esmeralda', 'categoria' => 'Faldas'],
            ['nombre' => 'Blusa Seda Estampada', 'valor' => 70000, 'marca' => 'Fashionista', 'talla' => 'S', 'color' => 'Crema con Patrón', 'categoria' => 'Blusas'],
            ['nombre' => 'Zapatos Deportivos', 'valor' => 95000, 'marca' => 'RunFast', 'talla' => '40', 'color' => 'Azul Marino', 'categoria' => 'Calzado'],
            ['nombre' => 'Cinturón Cuero Clásico', 'valor' => 30000, 'marca' => 'AccesoriosTop', 'talla' => '90cm', 'color' => 'Marrón', 'categoria' => 'Accesorios'],
            ['nombre' => 'Gorra de Béisbol', 'valor' => 18000, 'marca' => 'SportCap', 'talla' => 'Única', 'color' => 'Negro', 'categoria' => 'Gorras'],
            ['nombre' => 'Calcetines Tobilleros x3', 'valor' => 10000, 'marca' => 'ComfortFeet', 'talla' => 'L', 'color' => 'Variado', 'categoria' => 'Ropa Interior'],
            ['nombre' => 'Chaqueta de Cuero Moto', 'valor' => 250000, 'marca' => 'BikerStyle', 'talla' => 'M', 'color' => 'Negro', 'categoria' => 'Abrigos'],
            ['nombre' => 'Polo Piqué Algodón', 'valor' => 38000, 'marca' => 'ClassicWear', 'talla' => 'L', 'color' => 'Azul Claro', 'categoria' => 'Camisas Polo'],
            ['nombre' => 'Shorts Deportivos', 'valor' => 30000, 'marca' => 'ActiveLife', 'talla' => 'S', 'color' => 'Negro', 'categoria' => 'Pantalones Cortos'],
            ['nombre' => 'Bufanda de Lana', 'valor' => 22000, 'marca' => 'WinterWarmth', 'talla' => 'Única', 'color' => 'Rojo', 'categoria' => 'Accesorios'],
            ['nombre' => 'Suéter de Punto Delgado', 'valor' => 50000, 'marca' => 'CozyKnit', 'talla' => 'M', 'color' => 'Beige', 'categoria' => 'Suéteres'],
            ['nombre' => 'Bikini Floral', 'valor' => 40000, 'marca' => 'BeachDays', 'talla' => 'S', 'color' => 'Rosa Floral', 'categoria' => 'Trajes de Baño'],
            ['nombre' => 'Pijama Algodón', 'valor' => 35000, 'marca' => 'SweetDreams', 'talla' => 'M', 'color' => 'Rayas Azules', 'categoria' => 'Ropa Dormir'],
            ['nombre' => 'Zapatillas Casuales', 'valor' => 90000, 'marca' => 'UrbanWalk', 'talla' => '38', 'color' => 'Blanco', 'categoria' => 'Calzado'],
            ['nombre' => 'Guantes de Cuero', 'valor' => 42000, 'marca' => 'WinterEssentials', 'talla' => 'M', 'color' => 'Marrón Oscuro', 'categoria' => 'Accesorios'],
            ['nombre' => 'camiseta', 'valor' => 25000, 'marca' => 'nike', 'talla' => 'M', 'color' => 'Negra', 'categoria' => 'busos'],
        ]);
    }
}
