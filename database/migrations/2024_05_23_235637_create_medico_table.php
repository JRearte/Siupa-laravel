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
        Schema::create('medico', function (Blueprint $table) {
            $table->id();
            $table->string('Tipo', 12)->comment('Vacuna, Alergia, Discapacidad');
            $table->string('Nombre', 60);
            $table->unsignedBigInteger('infante_id');
            $table->timestamps();

            $table->foreign('infante_id')->references('id')->on('infante')->onDelete('cascade');
        });
    }

    /**
     * Revierte la migración
     */
    public function down(): void
    {
        Schema::dropIfExists('medico');
    }
};
