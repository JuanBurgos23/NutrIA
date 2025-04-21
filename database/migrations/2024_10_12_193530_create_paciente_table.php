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
        Schema::create('paciente', function (Blueprint $table) {
            $table->id('id_paciente');
            $table->unsignedBigInteger('id_user'); // FK hacia la tabla users
            $table->string('nombre');
            $table->string('paterno');
            $table->string('materno');
            $table->string('genero');
            $table->integer('edad');
            $table->string('celular')->nullable();
            $table->date('fecha_nac')->nullable();
            $table->string('direccion')->nullable();
            $table->timestamps();
            $table->foreign('id_user')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paciente');
    }
    
    
};
