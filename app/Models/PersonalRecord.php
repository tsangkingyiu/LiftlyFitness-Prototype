<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonalRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'exercise_id',
        'record_type',
        'value',
        'unit',
        'achieved_at',
        'workout_session_id',
        'notes',
    ];

    protected $casts = [
        'value' => 'decimal:2',
        'achieved_at' => 'date',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function exercise()
    {
        return $this->belongsTo(Exercise::class);
    }

    public function workoutSession()
    {
        return $this->belongsTo(WorkoutSession::class);
    }
}
