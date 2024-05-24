<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAsignaturaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asignatura', function (Blueprint $table) {
            $table->integer('Codigo_asignatura');
            $table->string('Nombre', 90);
            $table->date('Fecha')->nullable();
            $table->string('Condicion', 8)->nullable();
            $table->integer('Calificacion')->nullable();
            $table->integer('id_tutor');
            $table->integer('id_carrera');
            $table->integer('id_asignatura')->primary()->unique();
            
            $table->foreign('id_tutor', 'fk_asignatura_alumno1')->references('id_tutor')->on('alumno');
            $table->foreign('id_carrera', 'fk_asignatura_carrera1')->references('id_carrera')->on('carrera');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('asignatura');
    }
}
