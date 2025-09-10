<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
Schema::create('direcciones', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('id_usuario');
    $table->enum('tipo_entrega', ['tienda', 'domicilio']);
    $table->string('direccion')->nullable();
    $table->timestamps();

    // Ajustado: referencia a personas.id_persona
    $table->foreign('id_usuario')
          ->references('id_persona')
          ->on('personas')
          ->onDelete('cascade');
});
    }

    public function down(): void
    {
        Schema::dropIfExists('direcciones');
    }
};
