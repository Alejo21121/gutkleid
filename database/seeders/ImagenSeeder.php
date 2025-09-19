<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Imagen;
use Illuminate\Support\Facades\File;

class ImagenSeeder extends Seeder
{
    public function run(): void
    {
        $imagenes = [
            1 => ['buzobasic.webp','buzobasic2.webp'],
            2 => ['jeanbasic.webp','jeanbasic2.webp'],
            3 => ['chaqueta jeanh.webp', 'chaqueta jeanh2.webp'],
            4 => ['buzom1.webp', 'buzom2.webp'],
            5 => ['chaquetapff1.webp', 'chaquetapff2.webp'],
            6 => ['jeanbasic3.webp','jeanbasic4.webp'],
            7 => ['gorram2.webp'],
            
        ];

        $carpeta = public_path('IMG/imagenes_demo');

        foreach ($imagenes as $id_producto => $archivos) {
            foreach ($archivos as $archivo) {
                $ruta = $carpeta . '/' . $archivo;

                if (File::exists($ruta)) {
                    // Guardar directamente con su nombre original
                    Imagen::create([
                        'id_producto' => $id_producto,
                        'ruta' => 'IMG/imagenes_demo/' . $archivo,
                    ]);
                } else {
                    echo "⚠️ Imagen no encontrada: $archivo\n";
                }
            }
        }
    }
}
