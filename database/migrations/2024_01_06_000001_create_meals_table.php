<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('meals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('meal_type', ['breakfast', 'lunch', 'dinner', 'snack']);
            $table->date('date');
            $table->time('time')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->index(['user_id', 'date']);
            $table->index(['meal_type']);
        });

        Schema::create('meal_foods', function (Blueprint $table) {
            $table->id();
            $table->foreignId('meal_id')->constrained()->onDelete('cascade');
            $table->foreignId('food_id')->constrained()->onDelete('cascade');
            $table->decimal('quantity', 8, 2);
            $table->string('unit', 50);
            $table->timestamps();
            
            $table->index(['meal_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('meal_foods');
        Schema::dropIfExists('meals');
    }
};
