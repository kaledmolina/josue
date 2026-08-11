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
        Schema::table('albums', function (Blueprint $table) {
            // Portada por enlace externo (URL). Si está definida tiene prioridad sobre 'path'.
            $table->string('cover_image_url')->nullable()->after('path');
            // 'path' deja de ser obligatorio cuando la portada es una URL externa.
            $table->string('path')->nullable()->change();
        });

        Schema::table('files', function (Blueprint $table) {
            // URL externa de la imagen. Si está definida tiene prioridad sobre 'path'.
            $table->string('external_url')->nullable()->after('path');
            // Disco donde está almacenado el archivo (consistente con el modelo).
            $table->string('disk')->nullable()->default('google')->after('size');
            // Campos que dejan de ser obligatorios cuando la imagen es una URL externa.
            $table->string('path')->nullable()->change();
            $table->string('name')->nullable()->change();
            $table->string('mime_type')->nullable()->change();
            $table->string('size')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('albums', function (Blueprint $table) {
            $table->dropColumn('cover_image_url');
            $table->string('path')->nullable(false)->change();
        });

        Schema::table('files', function (Blueprint $table) {
            $table->dropColumn('external_url');
            $table->dropColumn('disk');
            $table->string('path')->nullable(false)->change();
            $table->string('name')->nullable(false)->change();
            $table->string('mime_type')->nullable(false)->change();
            $table->string('size')->nullable(false)->change();
        });
    }
};
