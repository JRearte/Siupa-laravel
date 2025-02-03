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
            $table->id();
            $table->string('Nombre', 30)->unique();
            $table->integer('Edad');
            $table->integer('Capacidad');
            $table->timestamps();
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
