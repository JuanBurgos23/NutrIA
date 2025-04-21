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
        Schema::create('ejercicio_dia', function (Blueprint $table) {
            $table->unsignedBigInteger('id_ejercicio');
            $table->unsignedBigInteger('id_dia');
            $table->foreign('id_ejercicio')->references('id')->on('ejercicio');
            $table->foreign('id_dia')->references('id')->on('dia');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ejercicio_dia');
    }
};
