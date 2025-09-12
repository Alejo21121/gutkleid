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
        Schema::create('factura_ventas', function (Blueprint $table) {
            $table->id('id_factura_venta');
            $table->string('nit_tienda');
            $table->string('dire_tienda');
            $table->string('telef_tienda');
            $table->date('fecha_venta');
            $table->enum('entrega', ['tienda', 'domicilio'])->default('tienda');
            $table->decimal('envio', 10, 2)->default(0);
            $table->decimal('total', 10, 2);
            $table->unsignedBigInteger('id_persona');
            $table->unsignedBigInteger('id_metodo_pago');
            $table->string('factura_pdf')->nullable();
            
            // Aquí se agrega la nueva columna
            $table->text('info_adicional')->nullable();

            $table->foreign('id_persona')->references('id_persona')->on('personas');
            $table->foreign('id_metodo_pago')->references('id_metodo_pago')->on('metodo_pagos');
            
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
        Schema::dropIfExists('factura_ventas');
    }
};