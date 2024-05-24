<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsuarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuario', function (Blueprint $table) {
            $table->integer('id_usuario')->primary()->unique();
            $table->string('Legajo', 13)->unique('Legajo_de_maestra_UNIQUE');
            $table->string('Nombre', 20);
            $table->string('Apellido', 20);
            $table->string('Categoria', 11)->comment("Coordinador\nMaestro");
            $table->string('Clave', 20)->nullable();
            $table->boolean('Habilitado')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('usuario');
    }
}
