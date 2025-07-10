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
Schema::create('factura_compras', function (Blueprint $table) {
    $table->id('id_factura_compras');
    $table->decimal('valor', 10, 2);
    $table->date('fecha_compra');
    $table->string('estado', 20);
    $table->unsignedBigInteger('id_proveedor');
    $table->foreign('id_proveedor')->references('id_proveedor')->on('proveedors');
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
        Schema::dropIfExists('factura_compras');
    }
};
