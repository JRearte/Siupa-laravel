<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ejecuta la migración.
     */
    public function up(): void
    {
        Schema::create('tutor', function (Blueprint $table) {
            $table->id();
            $table->string('Legajo', 13)->unique();
            $table->string('Nombre', 20);
            $table->string('Apellido', 20);
            $table->string('Genero', 9)->comment('Masculino, Femenino');
            $table->date('Fecha_de_nacimiento');
            $table->integer('Numero_documento')->unique();
            $table->string('Tipo_documento', 20);
            $table->string('Tipo_tutor', 10)->comment('Alumno, Trabajador');
            $table->tinyInteger('Habilitado');
            $table->timestamps();
        });
    }

    /**
     * Revierte la migración.
     */
    public function down(): void
    {
        Schema::dropIfExists('tutor');
    }
};
