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
        Schema::create('asistencia', function (Blueprint $table) {
            $table->id();
            $table->date('Fecha');
            $table->time('Hora_Ingreso')->nullable()->comment('Hora de ingreso del infante');
            $table->time('Hora_Salida')->nullable()->comment('Hora de salida del infante');
            $table->string('Estado', 25)->comment('Presente, Ausente Justificado, Ausente Injustificado');
            $table->string('Observacion', 255)->nullable()->comment('Notas adicionales sobre la asistencia');
            $table->unsignedBigInteger('usuario_id');
            $table->unsignedBigInteger('sala_id');
            $table->unsignedBigInteger('infante_id');
            $table->timestamps();
    
            $table->foreign('usuario_id')->references('id')->on('usuario')->onDelete('cascade');
            $table->foreign('sala_id')->references('id')->on('sala')->onDelete('cascade');
            $table->foreign('infante_id')->references('id')->on('infante')->onDelete('cascade');
        });
    }
    
    

    /**
     * Revierte la migración
     */
    public function down(): void
    {
        Schema::dropIfExists('asistencia');
    }
};
