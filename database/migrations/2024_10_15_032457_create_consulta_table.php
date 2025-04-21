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
        Schema::create('consulta', function (Blueprint $table) {
            $table->id();
            $table->string('motivo');
            $table->string('objetivo');
            $table->date('fecha_consulta');
            $table->unsignedBigInteger('id_imc')->nullable();
            $table->unsignedBigInteger('id_condicion')->nullable();
            $table->unsignedBigInteger('id_examen')->nullable();
            $table->unsignedBigInteger('id_paciente')->nullable();
            $table->foreign('id_imc')->references('id')->on('imc');
            $table->foreign('id_condicion')->references('id')->on('condicion');
            $table->foreign('id_examen')->references('id')->on('examen');
            $table->foreign('id_paciente')->references('id_paciente')->on('paciente');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consulta');
    }
};
