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
        Schema::create('sala', function (Blueprint $table) {
            $table->id();                                                                       // Columna 'id' de tipo integer autoincremental
            $table->string('Nombre', 30);                                                       // Columna 'Nombre_de_sala' de tipo varchar(30)
            $table->integer('Edad');                                                            // Columna 'Rango_de_edad' de tipo integer
            $table->integer('Capacidad');                                                       // Columna 'Capacidad' de tipo integer
            $table->timestamps();                                                               // Columnas para las marcas de tiempo de creación y actualización
        });
        
    }

    /**
     * Revierte la migración
     */
    public function down(): void
    {
        Schema::dropIfExists('sala');
    }
};
