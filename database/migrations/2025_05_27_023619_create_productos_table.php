<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
<<<<<<< HEAD
public function up()
{
    Schema::create('productos', function (Blueprint $table) {
        $table->id('id_producto');
        $table->string('nombre');
        $table->decimal('valor', 10, 2); // mejor para dinero
        $table->string('marca');
        $table->string('color');
        $table->unsignedBigInteger('id_impuesto');          // 🆕 nuevo campo
        $table->unsignedBigInteger('id_categoria');
        $table->timestamps();

        // Relaciones
        $table->foreign('id_impuesto')->references('id_impuesto')->on('impuestos');
        $table->foreign('id_categoria')->references('id_categoria')->on('categorias')->onDelete('cascade');
    });
}
=======
     public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id('id_producto');
            $table->string('nombre');
            $table->decimal('valor', 10, 2); // mejor para dinero
             $table->decimal('iva', 5, 2)->default(0.19); // <--- Aquí el IVA
            $table->string('marca');
            $table->string('color');
            $table->unsignedBigInteger('id_categoria');
            


            $table->timestamps();

            
            $table->foreign('id_categoria')->references('id_categoria')->on('categorias')->onDelete('cascade');
        });
    }
>>>>>>> 7a5405a3ab25780f3e4b9c9286bdc8fd2ad6a340

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('productos');
    }
};
