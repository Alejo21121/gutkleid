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
        Schema::create('detalles_compras', function (Blueprint $table) {
            $table->id('id_detalle');
            $table->unsignedBigInteger('id_factura_compras');
            $table->unsignedBigInteger('id_producto');
            $table->decimal('valor_unitario', 10, 2);
            $table->decimal('impuestos', 10, 2);
            $table->decimal('total', 10, 2);
            
            $table->foreign('id_producto')->references('id_producto')->on('productos');
            $table->foreign('id_factura_compras')->references('id_factura_compras')->on('factura_compras');
            
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
        Schema::dropIfExists('detalle_compras');
    }
};
