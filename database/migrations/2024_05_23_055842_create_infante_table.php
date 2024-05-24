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
        Schema::create('infante', function (Blueprint $table) {
            $table->id();
            $table->string('Nombre', 20);
            $table->string('Apellido', 20);
            $table->string('Genero', 9)->comment('Masculino, Femenino');
            $table->date('Fecha_de_nacimiento');
            $table->integer('Numero_documento');
            $table->string('Tipo_documento', 20);
            $table->string('Categoria', 10)->comment('Ingresante, Readmitido');
            $table->date('Fecha_de_asignacion');
            $table->tinyInteger('Habilitado');
            $table->unsignedBigInteger('domicilio_id');
            $table->unsignedBigInteger('tutor_id');
            $table->unsignedBigInteger('sala_id');
            $table->timestamps();

            $table->foreign('tutor_id')->references('id')->on('tutor')->onDelete('cascade');
            $table->foreign('domicilio_id')->references('id')->on('domicilio')->onDelete('cascade');
            $table->foreign('sala_id')->references('id')->on('sala')->onDelete('cascade');
        });
    }

    /**
     * Revierte la migración
     */
    public function down(): void
    {
        Schema::dropIfExists('infante');
    }
};
