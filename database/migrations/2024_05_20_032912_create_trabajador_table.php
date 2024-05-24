<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ejecuta la migración
     */
    public function up(): void
    {
        Schema::create('trabajador', function (Blueprint $table) {
            $table->id();
            $table->integer('Hora')->comment('Horas de trabajo diario');
            $table->string('Cargo', 35);
            $table->string('Tipo', 10)->comment('Docente, No docente');
            $table->unsignedBigInteger('tutor_id');
            $table->timestamps();

            $table->foreign('tutor_id')->references('id')->on('tutor')->onDelete('cascade');
        });
    }

    /**
     * Revierte la migración
     */
    public function down(): void
    {
        Schema::dropIfExists('trabajador');
    }
};
