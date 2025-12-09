<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('foods', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('brand')->nullable();
            $table->string('barcode')->nullable()->unique();
            $table->decimal('serving_size', 8, 2);
            $table->string('serving_unit', 50); // g, ml, oz, cup, etc.
            $table->decimal('calories', 8, 2);
            $table->decimal('protein', 8, 2)->default(0);
            $table->decimal('carbs', 8, 2)->default(0);
            $table->decimal('fat', 8, 2)->default(0);
            $table->decimal('fiber', 8, 2)->nullable();
            $table->decimal('sugar', 8, 2)->nullable();
            $table->decimal('sodium', 8, 2)->nullable();
            $table->boolean('is_verified')->default(false);
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            
            $table->index(['name']);
            $table->index(['brand']);
            $table->index(['is_verified']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('foods');
    }
};
