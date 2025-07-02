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
            1 => ['buso sc.jpg','buzo sc2.webp', 'buzo sc3.webp', 'buzo sc5.webp'],
            2 => ['jean.jpg'],
            3 => ['chaqueta jeanh.jpg', 'chaqueta jeanh2.webp'],
            4 => ['buzom1.webp', 'buzom2.webp'],
            5 => ['chaquetapff1.webp', 'chaquetapff2.webp', 'chaquetapff3.webp'],
            6 => ['jeanh1.webp'],
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
