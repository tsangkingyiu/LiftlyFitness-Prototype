<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meal extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'meal_type',
        'date',
        'time',
        'notes',
    ];

    protected $casts = [
        'date' => 'date',
        'time' => 'datetime:H:i',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function foods()
    {
        return $this->belongsToMany(Food::class, 'meal_foods')
            ->withPivot(['quantity', 'unit'])
            ->withTimestamps();
    }

    // Scopes
    public function scopeByDate($query, $date)
    {
        return $query->whereDate('date', $date);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('meal_type', $type);
    }

    // Helper methods
    public function getTotalNutrition()
    {
        $totals = [
            'calories' => 0,
            'protein' => 0,
            'carbs' => 0,
            'fat' => 0,
        ];

        foreach ($this->foods as $food) {
            $nutrition = $food->calculateNutrition($food->pivot->quantity, $food->pivot->unit);
            $totals['calories'] += $nutrition['calories'];
            $totals['protein'] += $nutrition['protein'];
            $totals['carbs'] += $nutrition['carbs'];
            $totals['fat'] += $nutrition['fat'];
        }

        return $totals;
    }
}
