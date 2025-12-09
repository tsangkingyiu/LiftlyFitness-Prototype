<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('personal_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('exercise_id')->constrained()->onDelete('cascade');
            $table->enum('record_type', ['max_weight', 'max_reps', 'max_distance', 'fastest_time']);
            $table->decimal('value', 10, 2);
            $table->string('unit', 20); // kg, lbs, reps, km, minutes, etc.
            $table->date('achieved_at');
            $table->foreignId('workout_session_id')->nullable()->constrained()->onDelete('set null');
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->index(['user_id', 'exercise_id']);
            $table->index(['achieved_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('personal_records');
    }
};
