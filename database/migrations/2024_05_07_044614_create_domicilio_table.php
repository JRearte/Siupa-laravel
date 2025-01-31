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
        Schema::create('domicilio', function (Blueprint $table) {
            $table->id();
            $table->string('Provincia', 30);
            $table->string('Localidad', 30);
            $table->integer('Codigo_postal');
            $table->string('Barrio', 35);
            $table->string('Calle', 40);
            $table->string('Numero', 25)->comment('Ejemplo especial: Manzana 129 Lote 4');
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
        Schema::dropIfExists('domicilio');
    }
};
