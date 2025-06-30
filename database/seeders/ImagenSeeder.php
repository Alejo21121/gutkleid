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
            // id_producto => [nombres de archivos de imagen]
            1 => ['buzo sc2.webp', 'buso sc.jpg', 'buzo sc3.webp' , 'buzo sc5.webp' ],
            2 => ['jean.jpg'],
            3 => ['chaqueta jeanh.jpg', 'chaqueta jeanh2.webp'],
            4 => ['buzom1.webp','buzom2.webp'],
            5 => ['chaquetapff1.webp', 'chaquetapff2.webp', 'chaquetapff3.webp'],
            6 => ['jeanh1.webp'],
            7 => ['gorram2.webp'],
        ];

        foreach ($imagenes as $id_producto => $archivos) {
            foreach ($archivos as $archivo) {
                $ruta_origen = public_path("IMG/imagenes_demo/$archivo");

                if (File::exists($ruta_origen)) {
                    // Generar un nombre único para evitar colisiones
                    $nombre_archivo = uniqid() . '_' . $archivo;

                    // Ruta destino dentro de public/storage/productos
                    $ruta_destino = "productos/$nombre_archivo";

                    // Crear carpeta si no existe
                    if (!File::exists(public_path("storage/productos"))) {
                        File::makeDirectory(public_path("storage/productos"), 0755, true);
                    }

                    // Copiar el archivo
                    copy($ruta_origen, public_path("storage/$ruta_destino"));

                    // Guardar en la base de datos
                    Imagen::create([
                        'id_producto' => $id_producto,
                        'ruta' => $ruta_destino,
                    ]);
                } else {
                    echo "⚠️ Imagen no encontrada: $archivo\n";
                }
            }
        }
    }
}
