<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrabajadorUniversitarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trabajador_universitario', function (Blueprint $table) {
            $table->integer('Horas_de_trabajo');
            $table->string('Cargo_de_trabajo', 35)->nullable();
            $table->string('Tipo_trabajador', 10)->comment("Docente\nNo docente");
            $table->integer('id_tutor')->primary();
            
            $table->foreign('id_tutor', 'fk_trabajador_universitario_tutor1')->references('id_tutor')->on('tutor');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trabajador_universitario');
    }
}
