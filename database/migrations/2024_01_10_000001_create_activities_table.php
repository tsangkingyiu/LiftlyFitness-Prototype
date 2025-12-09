<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('type', 100); // workout_completed, measurement_logged, achievement_unlocked, etc.
            $table->morphs('activityable'); // Polymorphic relation
            $table->json('data')->nullable();
            $table->integer('likes_count')->default(0);
            $table->integer('comments_count')->default(0);
            $table->timestamps();
            
            $table->index(['user_id', 'created_at']);
            $table->index(['type']);
        });

        Schema::create('activity_likes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('activity_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            
            $table->unique(['activity_id', 'user_id']);
        });

        Schema::create('activity_comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('activity_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->text('comment');
            $table->timestamps();
            
            $table->index(['activity_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_comments');
        Schema::dropIfExists('activity_likes');
        Schema::dropIfExists('activities');
    }
};
