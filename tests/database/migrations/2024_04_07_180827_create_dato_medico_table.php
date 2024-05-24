<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDatoMedicoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dato_medico', function (Blueprint $table) {
            $table->integer('id_dato_medico')->primary()->unique();
            $table->string('Tipo', 12)->comment("vacuna\ndiscapacidad\nalergia");
            $table->string('Nombre', 60);
            $table->integer('id_niño');
            
            $table->foreign('id_niño', 'fk_vacuna_niño1')->references('id_infante')->on('infante');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dato_medico');
    }
}
