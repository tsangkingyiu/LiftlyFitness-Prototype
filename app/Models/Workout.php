<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Workout extends Model
{
    use HasFactory, HasSlug, SoftDeletes;

    protected $fillable = [
        'user_id',
        'name',
        'slug',
        'description',
        'category',
        'duration',
        'difficulty',
        'is_public',
        'likes_count',
        'times_used',
    ];

    protected $casts = [
        'is_public' => 'boolean',
        'likes_count' => 'integer',
        'times_used' => 'integer',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function exercises()
    {
        return $this->belongsToMany(Exercise::class, 'workout_exercises')
            ->withPivot(['order', 'sets', 'reps', 'duration', 'rest', 'notes'])
            ->withTimestamps()
            ->orderBy('workout_exercises.order');
    }

    public function sessions()
    {
        return $this->hasMany(WorkoutSession::class);
    }

    // Scopes
    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopePopular($query)
    {
        return $query->orderBy('times_used', 'desc');
    }

    // Helper methods
    public function incrementTimesUsed()
    {
        $this->increment('times_used');
    }
}
