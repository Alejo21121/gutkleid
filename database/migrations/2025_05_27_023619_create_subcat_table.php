<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('subcategorias', function (Blueprint $table) {
            $table->id('id_subcategoria');
            $table->string('nombre');
            $table->unsignedBigInteger('id_categoria');
            $table->timestamps();

            // Relación con categorias
            $table->foreign('id_categoria')->references('id_categoria')->on('categorias')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('subcategorias');
    }
};
