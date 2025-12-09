<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('workout_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('workout_id')->nullable()->constrained()->onDelete('set null');
            $table->timestamp('started_at');
            $table->timestamp('completed_at')->nullable();
            $table->integer('duration')->nullable()->comment('Actual duration in minutes');
            $table->integer('calories_burned')->nullable();
            $table->text('notes')->nullable();
            $table->enum('status', ['in_progress', 'completed', 'cancelled'])->default('in_progress');
            $table->timestamps();
            
            $table->index(['user_id']);
            $table->index(['workout_id']);
            $table->index(['started_at']);
            $table->index(['status']);
        });

        Schema::create('workout_session_exercises', function (Blueprint $table) {
            $table->id();
            $table->foreignId('workout_session_id')->constrained()->onDelete('cascade');
            $table->foreignId('exercise_id')->constrained()->onDelete('cascade');
            $table->integer('sets_completed')->default(0);
            $table->integer('reps_completed')->nullable();
            $table->decimal('weight_used', 8, 2)->nullable()->comment('Weight in kg');
            $table->integer('duration')->nullable()->comment('Duration in seconds');
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->index(['workout_session_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('workout_session_exercises');
        Schema::dropIfExists('workout_sessions');
    }
};
