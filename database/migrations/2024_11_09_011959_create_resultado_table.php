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
        Schema::create('resultado', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_planNutricional')->nullable();
            $table->string('descripcion')->nullable();
            $table->foreign('id_planNutricional')->references('id')->on('plan_nutricional');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resultado');
    }
};
