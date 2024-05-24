<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCorreoElectronicoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('correo_electronico', function (Blueprint $table) {
            $table->string('E_mail', 45);
            $table->integer('id_correo')->primary()->unique();
            $table->integer('id_tutor');
            
            $table->foreign('id_tutor', 'fk_Correo_electronico_tutor1')->references('id_tutor')->on('tutor');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('correo_electronico');
    }
}
