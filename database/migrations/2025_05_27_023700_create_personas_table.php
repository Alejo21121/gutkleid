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
        Schema::create('personas', function (Blueprint $table) {
            $table->id('id_persona');
            $table->string('documento');
            $table->unsignedBigInteger('id_tipo_documento');
            $table->date('fecha_nacimiento');
            $table->string('nombres');
            $table->string('apellidos');
            $table->string('correo');
            $table->string('telefono');
            $table->string('direccion');
            $table->text('info_adicional')->nullable();
            $table->string('contraseña');
            $table->unsignedBigInteger('id_rol');
            $table->string('imagen')->nullable();
            $table->foreign('id_tipo_documento')->references('id_tipo_documento')->on('tipo_documentos');
            $table->foreign('id_rol')->references('id_rol')->on('rols');
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
        Schema::dropIfExists('personas');
    }
};
