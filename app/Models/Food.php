<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'brand',
        'barcode',
        'serving_size',
        'serving_unit',
        'calories',
        'protein',
        'carbs',
        'fat',
        'fiber',
        'sugar',
        'sodium',
        'is_verified',
        'created_by',
    ];

    protected $casts = [
        'serving_size' => 'decimal:2',
        'calories' => 'decimal:2',
        'protein' => 'decimal:2',
        'carbs' => 'decimal:2',
        'fat' => 'decimal:2',
        'fiber' => 'decimal:2',
        'sugar' => 'decimal:2',
        'sodium' => 'decimal:2',
        'is_verified' => 'boolean',
    ];

    // Relationships
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function meals()
    {
        return $this->belongsToMany(Meal::class, 'meal_foods')
            ->withPivot(['quantity', 'unit'])
            ->withTimestamps();
    }

    // Scopes
    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'like', "%{$search}%")
            ->orWhere('brand', 'like', "%{$search}%");
    }

    // Helper methods
    public function calculateNutrition($quantity, $unit = null)
    {
        $multiplier = $quantity / $this->serving_size;
        
        return [
            'calories' => round($this->calories * $multiplier, 2),
            'protein' => round($this->protein * $multiplier, 2),
            'carbs' => round($this->carbs * $multiplier, 2),
            'fat' => round($this->fat * $multiplier, 2),
        ];
    }
}
