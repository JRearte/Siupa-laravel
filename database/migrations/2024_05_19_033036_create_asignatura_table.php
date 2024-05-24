<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    
    /**
     * Ejecuta la migración
     */
    public function up(): void
    {
        Schema::create('asignatura', function (Blueprint $table) {
            $table->id();
            $table->integer('Codigo');
            $table->string('Nombre', 90);
            $table->date('Fecha');
            $table->string('Condicion', 8)->comment('Cursando, Libre, Regular, Aprobado');
            $table->integer('Calificacion');
            $table->unsignedBigInteger('tutor_id');
            $table->unsignedBigInteger('carrera_id');
            $table->timestamps();

            $table->foreign('tutor_id')->references('id')->on('tutor')->onDelete('cascade');
            $table->foreign('carrera_id')->references('id')->on('carrera')->onDelete('cascade');
        });
    }

    /**
     * Revierte la migración
     */
    public function down(): void
    {
        Schema::dropIfExists('asignatura');
    }
};

