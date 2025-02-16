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
        Schema::create('familia', function (Blueprint $table) {
            $table->id();
            $table->string('Nombre', 20);
            $table->string('Apellido', 20);
            $table->string('Vinculo', 11)->comment('Padre, Madre, Padrastro, Madrastra, Tío, Tía, Primo, Prima, Hermano, Hermana, Hermanastro, Hermanastra, Abuelo, Abuela');
            $table->date('Fecha_de_nacimiento');
            $table->integer('Numero_documento')->unique();
            $table->string('Tipo_documento', 20);
            $table->string('Lugar_de_trabajo', 50)->nullable();
            $table->decimal('Ingreso', 9, 2)->nullable();
            $table->tinyInteger('Habilitado');
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
        Schema::dropIfExists('familia');
    }
};
