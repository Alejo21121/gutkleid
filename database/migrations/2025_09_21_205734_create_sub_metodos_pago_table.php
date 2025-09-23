<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('sub_metodos_pago', function (Blueprint $table) {
            $table->id('id_sub_metodo');
            $table->unsignedBigInteger('id_metodo_pago');
            $table->string('nombre', 50);
            $table->timestamps();

            $table->foreign('id_metodo_pago')
                  ->references('id_metodo_pago')->on('metodo_pagos')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('sub_metodos_pago');
    }
};
