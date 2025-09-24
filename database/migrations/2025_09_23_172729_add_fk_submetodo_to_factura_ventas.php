<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('factura_ventas', function (Blueprint $table) {
            // Primero agregamos la columna
            $table->unsignedBigInteger('id_sub_metodo')->nullable()->after('id_metodo_pago');

            // Luego agregamos la foreign key correctamente
            $table->foreign('id_sub_metodo')
                  ->references('id_sub_metodo')
                  ->on('sub_metodos_pago')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('factura_ventas', function (Blueprint $table) {
            $table->dropForeign(['id_sub_metodo']);
            $table->dropColumn('id_sub_metodo');
        });
    }
};
