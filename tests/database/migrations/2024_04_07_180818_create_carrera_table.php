<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarreraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carrera', function (Blueprint $table) {
            $table->integer('Codigo_carrera');
            $table->string('Nombre', 50);
            $table->integer('id_tutor');
            $table->integer('id_carrera')->primary()->unique();
            
            $table->foreign('id_tutor', 'fk_carrera_alumno1')->references('id_tutor')->on('alumno');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('carrera');
    }
}
