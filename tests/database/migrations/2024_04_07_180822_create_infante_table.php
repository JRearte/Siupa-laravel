<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInfanteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('infante', function (Blueprint $table) {
            $table->integer('id_infante')->unique('id_niño_UNIQUE');
            $table->integer('Numero_documento')->unique('Número_documento_UNIQUE');
            $table->string('Nombre', 20);
            $table->string('Apellido', 20);
            $table->string('Genero', 9)->comment("Masculino\nFemenino");
            $table->string('tipo_documento', 15)->nullable();
            $table->date('Fecha_de_nacimiento');
            $table->string('categoria', 10)->nullable();
            $table->date('Fecha_de_asignacion');
            $table->integer('id_sala');
            $table->integer('id_tutor');
            $table->boolean('Habilitado')->default(1);
            
            $table->primary(['id_infante', 'id_tutor']);
            $table->foreign('id_sala', 'fk_niño_sala1')->references('id_sala')->on('sala');
            $table->foreign('id_tutor', 'fk_niño_tutor1')->references('id_tutor')->on('tutor');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('infante');
    }
}
