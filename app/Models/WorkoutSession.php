<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkoutSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'workout_id',
        'started_at',
        'completed_at',
        'duration',
        'calories_burned',
        'notes',
        'status',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function workout()
    {
        return $this->belongsTo(Workout::class);
    }

    public function exercises()
    {
        return $this->belongsToMany(Exercise::class, 'workout_session_exercises')
            ->withPivot(['sets_completed', 'reps_completed', 'weight_used', 'duration', 'notes'])
            ->withTimestamps();
    }

    // Scopes
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeInProgress($query)
    {
        return $query->where('status', 'in_progress');
    }

    // Helper methods
    public function complete()
    {
        $this->update([
            'completed_at' => now(),
            'status' => 'completed',
            'duration' => $this->started_at->diffInMinutes(now()),
        ]);
    }

    public function cancel()
    {
        $this->update(['status' => 'cancelled']);
    }
}
