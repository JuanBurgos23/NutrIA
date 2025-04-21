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
        Schema::create('horario', function (Blueprint $table) {
            $table->id();
            $table->string('hora');  //aqui cambie a varchar
            $table->unsignedBigInteger('id_periodo');
            $table->unsignedBigInteger('id_dia');
            $table->foreign('id_periodo')->references('id')->on('periodo');
            $table->foreign('id_dia')->references('id')->on('dia');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('horario');
    }
};
