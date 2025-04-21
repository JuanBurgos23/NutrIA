<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('mensaje_notificacions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_user')->nullable();
            $table->string('type');
            $table->string('correo_remitente')->nullable();
            $table->text('data')->nullable();;
            $table->text('asunto')->nullable();;
            $table->mediumText('mensaje')->nullable();;
            $table->boolean('read')->default(false);
            $table->foreign('id_user')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mensaje_notificacions');
    }
};