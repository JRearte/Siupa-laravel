<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAsistenciaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asistencia', function (Blueprint $table) {
            $table->integer('id_asistencia')->primary();
            $table->date('Fecha');
            $table->time('Hora');
            $table->string('Tipo_de_inasistencia', 13)->nullable()->comment("Justificado\nInjustificado");
            $table->integer('id_sala');
            $table->integer('id_usuario')->nullable();
            $table->integer('id_infante')->nullable();
            
            $table->foreign('id_usuario', 'fk_asistencia_docente1')->references('id_usuario')->on('usuario');
            $table->foreign('id_infante', 'fk_asistencia_niño1')->references('id_infante')->on('infante');
            $table->foreign('id_sala', 'fk_asistencia_sala1')->references('id_sala')->on('sala');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('asistencia');
    }
}
