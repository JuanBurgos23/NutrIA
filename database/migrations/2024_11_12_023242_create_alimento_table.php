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
        Schema::create('alimento', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('caloria')->nullable();
            $table->string('carbohidrato')->nullable();
            $table->string('proteina')->nullable();
            $table->string('grasa')->nullable();
            $table->string('nombreImagen')->nullable();
            $table->unsignedBigInteger('id_tipoAlimento');
            $table->foreign('id_tipoAlimento')->references('id')->on('tipo_alimento');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alimento');
    }
};
