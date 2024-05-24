<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCuotaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cuota', function (Blueprint $table) {
            $table->integer('id_cuota')->primary()->unique();
            $table->decimal('valor', 9, 2)->nullable();
            $table->date('Fecha');
            $table->integer('id_tutor');
            
            $table->foreign('id_tutor', 'fk_cuota_trabajador_universitario1')->references('id_tutor')->on('trabajador_universitario');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cuota');
    }
}
