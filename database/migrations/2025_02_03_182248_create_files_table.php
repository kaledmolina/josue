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
        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('album_id')
            ->nullable()
            ->constrained('albums') // Asegúrate que la tabla albums existe
            ->onDelete('cascade');
            $table->string('path')->unique(); // Almacenará rutas separadas por comas
            $table->string('name'); // Nombres originales separados por comas
            $table->string('mime_type'); // Tipos MIME separados por comas
            $table->string('size');// Tamaño en bytes
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('files');
    }
};
