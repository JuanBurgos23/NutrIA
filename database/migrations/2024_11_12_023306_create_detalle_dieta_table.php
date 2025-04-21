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
        Schema::create('detalle_dieta', function (Blueprint $table) {
            $table->unsignedBigInteger('id_alimento')->unique;
            $table->unsignedBigInteger('id_periodo')->unique;
            $table->unsignedBigInteger('id_dieta')->unique;
            $table->unsignedBigInteger('id_dia')->unique;
            $table->unsignedBigInteger('id_horario')->unique;
            $table->foreign('id_dieta')->references('id')->on('dieta');
            $table->foreign('id_alimento')->references('id')->on('alimento');
            $table->foreign('id_periodo')->references('id_periodo')->on('horario');
            $table->foreign('id_dia')->references('id_dia')->on('horario');
            $table->foreign('id_horario')->references('id')->on('horario');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_dieta');
    }
};
