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
     public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id('id_producto');
            $table->string('nombre');
            $table->decimal('valor', 10, 2); // mejor para dinero
            $table->string('marca');
            $table->string('talla');
            $table->string('color');
            $table->unsignedBigInteger('id_categoria');
            $table->integer('cantidad')->default(0); // nueva columna

            $table->timestamps();

            // Llave foránea hacia categorías
            $table->foreign('id_categoria')->references('id_categoria')->on('categorias')->onDelete('cascade');
        });
    }

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
