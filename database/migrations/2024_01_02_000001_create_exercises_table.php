<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('exercises', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('category', 100); // strength, cardio, flexibility, hiit, etc.
            $table->string('muscle_group', 100); // chest, back, legs, arms, etc.
            $table->string('equipment', 100)->nullable(); // barbell, dumbbell, bodyweight, etc.
            $table->enum('difficulty', ['beginner', 'intermediate', 'advanced']);
            $table->text('instructions')->nullable();
            $table->string('video_url')->nullable();
            $table->string('thumbnail')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->index(['category']);
            $table->index(['muscle_group']);
            $table->index(['difficulty']);
            $table->index(['is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('exercises');
    }
};
