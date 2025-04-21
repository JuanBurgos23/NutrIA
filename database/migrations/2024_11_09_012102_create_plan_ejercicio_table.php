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
        Schema::create('plan_ejercicio', function (Blueprint $table) {
            
            $table->unsignedBigInteger('id_planNutricional')->nullable();
            $table->unsignedBigInteger('id_ejercicio')->nullable();
            $table->foreign('id_planNutricional')->references('id')->on('plan_nutricional');
            $table->foreign('id_ejercicio')->references('id')->on('ejercicio');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plan_ejercicio');
    }
};
