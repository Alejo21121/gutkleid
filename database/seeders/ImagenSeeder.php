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
            8 => ['camisa_amarilla.PNG','camisa_amarilla2.PNG','camisa_amarilla3.PNG','camisa_amarilla4.PNG'],
            9 => ['camisa_azul.PNG','camisa_azul2.PNG','camisa_azul3.PNG','camisa_azul4.PNG'],
            10 => ['camisa_blanca.PNG','camisa_blanca2.PNG'],
            11 => ['camisa_cafe.PNG','camisa_cafe2.PNG','camisa_cafe3.PNG','camisa_cafe4.PNG'],
            12 => ['camisa_mujera.PNG','camisa_mujera2.PNG','camisa_mujera3.PNG'],
            13 => ['camisa_mujerb.PNG','camisa_mujerb2.PNG','camisa_mujerb3.PNG','camisa_mujerb4.PNG'],
            14 => ['camisa_mujerr.PNG','camisa_mujerr2.PNG'],
            15 => ['jean_gris.PNG','jean_gris2.PNG','jean_gris3.PNG','jean_gris4.PNG'],
            16 => ['jean_veige.PNG','jean_veige2.PNG','jean_veige3.PNG','jean_veige4.PNG'],
            17 => ['manga_larga.PNG','manga_larga2.PNG','manga_larga3.PNG','manga_larga4.PNG'],
            18 => ['pantalon_azul.PNG','pantalon_azul2.PNG','pantalon_azul3.PNG','pantalon_azul4.PNG'],
            19 => ['pantalon_blanco.PNG','pantalon_blanco2.PNG','pantalon_blanco3.PNG','pantalon_blanco4.PNG'],
            20 => ['pantalon_cafe.PNG','pantalon_cafe2.PNG'],
            21 => ['pantalon_negro.PNG','pantalon_negro2.PNG','pantalon_negro3.PNG','pantalon_negro4.PNG'],
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
