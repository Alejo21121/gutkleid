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
       Schema::create('imagenes', function (Blueprint $table) {
        $table->id('id_imagen');
        $table->unsignedBigInteger('id_producto'); // FK al producto
        $table->string('ruta'); // nombre del archivo o ruta
        $table->timestamps();

        $table->foreign('id_producto')->references('id_producto')->on('productos')->onDelete('cascade');
    });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('imgenes');
    }
};
