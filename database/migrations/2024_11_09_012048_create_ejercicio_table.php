<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ejercicio', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('descripcion')->nullable();
            $table->string('series')->nullable();
            $table->string('repeticiones')->nullable();
            $table->string('descanso')->nullable();
            $table->unsignedBigInteger('id_tipoEjercicio');
            $table->foreign('id_tipoEjercicio')->references('id')->on('tipo_ejercicio');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ejercicio');
    }
};
