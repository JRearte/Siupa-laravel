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
        Schema::create('cuota', function (Blueprint $table) {
            $table->id();
            $table->decimal('Valor', 9, 2);
            $table->date('Fecha');
            $table->unsignedBigInteger('trabajador_id');
            $table->timestamps();

            $table->foreign('trabajador_id')->references('id')->on('trabajador')->onDelete('cascade');
        });
    }

    /**
     * Revierte la migración
     */
    public function down(): void
    {
        Schema::dropIfExists('cuota');
    }
};
