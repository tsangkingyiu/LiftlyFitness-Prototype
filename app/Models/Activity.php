<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'activityable_type',
        'activityable_id',
        'data',
        'likes_count',
        'comments_count',
    ];

    protected $casts = [
        'data' => 'array',
        'likes_count' => 'integer',
        'comments_count' => 'integer',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function activityable()
    {
        return $this->morphTo();
    }

    public function likes()
    {
        return $this->hasMany(ActivityLike::class);
    }

    public function comments()
    {
        return $this->hasMany(ActivityComment::class);
    }

    // Helper methods
    public function like(User $user)
    {
        if (!$this->isLikedBy($user)) {
            $this->likes()->create(['user_id' => $user->id]);
            $this->increment('likes_count');
        }
    }

    public function unlike(User $user)
    {
        $like = $this->likes()->where('user_id', $user->id)->first();
        if ($like) {
            $like->delete();
            $this->decrement('likes_count');
        }
    }

    public function isLikedBy(User $user)
    {
        return $this->likes()->where('user_id', $user->id)->exists();
    }
}
