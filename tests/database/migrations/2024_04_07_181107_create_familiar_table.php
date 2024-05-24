<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFamiliarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('familiar', function (Blueprint $table) {
            $table->integer('id_familiar')->primary()->unique();
            $table->string('Nombre', 20);
            $table->string('Apellido', 20);
            $table->date('Fecha_de_nacimiento');
            $table->integer('Numero_documento')->unique('Número_documento_familiar_UNIQUE');
            $table->string('Tipo_de_documento', 15)->nullable();
            $table->string('Vinculo', 11)->comment("Padre\nPadrastro\nMadre\nMadrastra\nHermano\nHermana\nHermanastro\nHermanastra\nAbuelo\nAbuela\nNieto\nNieta\nTío\nTía\nSobrino\nSobrina\nPrimo\nPrima");
            $table->integer('id_infante');
            $table->string('lugar_de_trabajo', 40)->nullable();
            $table->decimal('ingreso', 9, 2)->nullable();
            $table->boolean('Habilitado')->default(1);
            
            $table->foreign('id_infante', 'fk_familiar_niño1')->references('id_infante')->on('infante');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('familiar');
    }
}
