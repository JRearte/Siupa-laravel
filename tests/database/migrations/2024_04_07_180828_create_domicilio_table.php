<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDomicilioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('domicilio', function (Blueprint $table) {
            $table->string('Provincia', 50);
            $table->string('Localidad', 40);
            $table->integer('Codigo_postal');
            $table->string('Barrio', 30);
            $table->string('Calle', 40);
            $table->string('Numero', 12)->comment("En ciertos casos las casas no tienen numeros, si no un nombre como \\n\\nEj: Lote 4");
            $table->integer('id_tutor')->nullable();
            $table->integer('id_infante')->nullable();
            
            $table->foreign('id_infante', 'fk_domicilio_niño1')->references('id_infante')->on('infante');
            $table->foreign('id_tutor', 'fk_domicilio_tutor1')->references('id_tutor')->on('tutor');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('domicilio');
    }
}
