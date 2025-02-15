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
        Schema::create('about_contents', function (Blueprint $table) {
            $table->id();
            $table->string('hero_title');
            $table->text('hero_description');
            $table->string('education_title');
            $table->string('education_institution');
            $table->string('education_dates');
            $table->text('education_details');
            $table->string('experience_title');
            $table->string('experience_company');
            $table->string('experience_dates');
            $table->text('experience_details');
            $table->json('skills')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('about_contents');
    }
};
