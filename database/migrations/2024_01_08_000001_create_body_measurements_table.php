<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('body_measurements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->date('date');
            $table->decimal('weight', 5, 2)->nullable()->comment('Weight in kg');
            $table->decimal('body_fat', 4, 2)->nullable()->comment('Body fat percentage');
            $table->decimal('muscle_mass', 5, 2)->nullable()->comment('Muscle mass in kg');
            $table->decimal('chest', 5, 2)->nullable()->comment('Chest circumference in cm');
            $table->decimal('waist', 5, 2)->nullable()->comment('Waist circumference in cm');
            $table->decimal('hips', 5, 2)->nullable()->comment('Hips circumference in cm');
            $table->decimal('arms', 5, 2)->nullable()->comment('Arms circumference in cm');
            $table->decimal('legs', 5, 2)->nullable()->comment('Legs circumference in cm');
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->index(['user_id', 'date']);
            $table->unique(['user_id', 'date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('body_measurements');
    }
};
