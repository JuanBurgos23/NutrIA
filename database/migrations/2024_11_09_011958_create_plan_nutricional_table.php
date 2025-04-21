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
        Schema::create('plan_nutricional', function (Blueprint $table) {
            $table->id();
            $table->string('descripcion');
            $table->string('estado');
            $table->unsignedBigInteger('id_periodo')->nullable();
            $table->unsignedBigInteger('id_dieta')->nullable();
            $table->unsignedBigInteger('id_diagnostico')->nullable();
            $table->foreign('id_periodo')->references('id')->on('periodo');
            $table->foreign('id_dieta')->references('id')->on('dieta');
            $table->foreign('id_diagnostico')->references('id')->on('diagnostico');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plan_nutricional');
    }
};
