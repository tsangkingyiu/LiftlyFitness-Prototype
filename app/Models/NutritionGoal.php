<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NutritionGoal extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'daily_calories',
        'protein_grams',
        'carbs_grams',
        'fat_grams',
        'water_ml',
        'start_date',
        'end_date',
        'is_active',
    ];

    protected $casts = [
        'protein_grams' => 'decimal:2',
        'carbs_grams' => 'decimal:2',
        'fat_grams' => 'decimal:2',
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
