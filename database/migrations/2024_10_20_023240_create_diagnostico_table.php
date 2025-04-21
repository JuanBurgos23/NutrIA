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
        Schema::create('diagnostico', function (Blueprint $table) {
            $table->id();
            $table->longText('detalle')->nullable();
            $table->longText('recomendacion')->nullable();
            $table->unsignedBigInteger('id_consulta')->nullable();
            $table->foreign('id_consulta')->references('id')->on('consulta');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diagnostico');
    }
};
