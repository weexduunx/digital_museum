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
        Schema::create('artworks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description_fr');
            $table->text('description_en')->nullable();
            $table->text('description_wo')->nullable();
            $table->string('artist');
            $table->year('creation_year')->nullable();
            $table->string('medium')->nullable();
            $table->string('dimensions')->nullable();
            $table->string('image_path')->nullable();
            $table->string('audio_path_fr')->nullable();
            $table->string('audio_path_en')->nullable();
            $table->string('audio_path_wo')->nullable();
            $table->string('video_path')->nullable();
            $table->string('qr_code')->unique();
            $table->json('historical_context')->nullable();
            $table->json('cultural_significance')->nullable();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('artworks');
    }
};
