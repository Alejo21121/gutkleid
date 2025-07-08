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
        Schema::create('detalles_factura_v_s', function (Blueprint $table) {
            $table->id('id_detalle_v');
            $table->unsignedBigInteger('id_factura_venta');
            
            $table->decimal('subtotal', 10, 2);
            $table->decimal('cantidad', 10, 2);
            $table->unsignedBigInteger('id_producto');
            

            $table->foreign('id_factura_venta')->references('id_factura_venta')->on('factura_ventas');
            $table->foreign('id_producto')->references('id_producto')->on('productos');
            
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
        Schema::dropIfExists('detalle_factura_v_s');
    }
};
