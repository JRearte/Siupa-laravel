<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTutorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tutor', function (Blueprint $table) {
            $table->integer('id_tutor')->primary()->unique();
            $table->string('Legajo', 13)->unique('idTutores_UNIQUE');
            $table->string('Nombre', 20);
            $table->string('Apellido', 20);
            $table->string('Genero', 9)->comment("Masculino\nFemenino");
            $table->date('Fecha_de_nacimiento');
            $table->integer('Numero_documento');
            $table->string('Tipo_documento', 15);
            $table->string('Tipo_tutor', 10)->comment("Alumno\nTrabajador");
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
        Schema::dropIfExists('tutor');
    }
}
