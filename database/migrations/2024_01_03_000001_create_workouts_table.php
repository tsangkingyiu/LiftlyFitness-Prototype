<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('workouts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('slug');
            $table->text('description')->nullable();
            $table->string('category', 100)->nullable();
            $table->integer('duration')->nullable()->comment('Estimated duration in minutes');
            $table->enum('difficulty', ['beginner', 'intermediate', 'advanced'])->nullable();
            $table->boolean('is_public')->default(false);
            $table->integer('likes_count')->default(0);
            $table->integer('times_used')->default(0);
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['user_id']);
            $table->index(['category']);
            $table->index(['is_public']);
            $table->index(['created_at']);
        });

        Schema::create('workout_exercises', function (Blueprint $table) {
            $table->id();
            $table->foreignId('workout_id')->constrained()->onDelete('cascade');
            $table->foreignId('exercise_id')->constrained()->onDelete('cascade');
            $table->integer('order')->default(0);
            $table->integer('sets')->nullable();
            $table->integer('reps')->nullable();
            $table->integer('duration')->nullable()->comment('Duration in seconds for timed exercises');
            $table->integer('rest')->default(60)->comment('Rest time in seconds');
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->index(['workout_id']);
            $table->index(['exercise_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('workout_exercises');
        Schema::dropIfExists('workouts');
    }
};
