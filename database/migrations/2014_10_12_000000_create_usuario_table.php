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
        Schema::create('usuario', function (Blueprint $table) {
            $table->id();                                                                           // Columna 'id' de tipo integer autoincremental
            $table->string('Legajo', 13)->unique();                                                 // Columna 'Legajo' de tipo varchar(13) y única
            $table->string('Nombre', 20);                                                           // Columna 'Nombre' de tipo varchar(20)
            $table->string('Apellido', 20);                                                         // Columna 'Apellido' de tipo varchar(20)
            $table->string('Categoria', 11)->comment('Invitado, Bienestar, Coordinador, Maestro');  // Columna 'Categoria' de tipo varchar(11) con comentario
            $table->string('password', 60);                                                         // Columna 'password' de tipo varchar(60)
            $table->tinyInteger('Habilitado');                                                      // Columna 'Habilitado' de tipo tinyint(1)
            $table->rememberToken();                                                                // Columna para recordar sesión
            $table->timestamps();                                                                   // Columnas para las marcas de tiempo de creación y actualización
        });
    }

    /**
     * Revierte la migración
     */
    public function down(): void
    {
        Schema::dropIfExists('usuario');
    }
};
