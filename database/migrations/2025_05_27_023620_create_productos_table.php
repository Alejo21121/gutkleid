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
            $table->decimal('valor', 10, 2);
            $table->decimal('iva', 5, 2)->default(0.19);
            $table->string('marca');
            $table->string('color');
            $table->enum('sexo', ['Hombre', 'Mujer', 'Unisex'])->default('Unisex');

            // Relación con categorías
            $table->unsignedBigInteger('id_categoria');
            $table->foreign('id_categoria')
                ->references('id_categoria')
                ->on('categorias')
                ->onDelete('cascade');

            // Relación con subcategorías (nuevo)
            $table->unsignedBigInteger('id_subcategoria')->nullable();
            $table->foreign('id_subcategoria')
                ->references('id_subcategoria')
                ->on('subcategorias')
                ->onDelete('set null');

            $table->timestamps();
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
