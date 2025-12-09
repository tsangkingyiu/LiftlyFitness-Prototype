<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Meal;
use Illuminate\Http\Request;

class MealController extends Controller
{
    /**
     * Log a new meal
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'meal_type' => 'required|in:breakfast,lunch,dinner,snack',
            'date' => 'required|date',
            'time' => 'nullable|date_format:H:i',
            'notes' => 'nullable|string',
            'foods' => 'required|array|min:1',
            'foods.*.food_id' => 'required|exists:foods,id',
            'foods.*.quantity' => 'required|numeric|min:0',
            'foods.*.unit' => 'required|string|max:50',
        ]);

        $meal = $request->user()->meals()->create([
            'meal_type' => $validated['meal_type'],
            'date' => $validated['date'],
            'time' => $validated['time'] ?? null,
            'notes' => $validated['notes'] ?? null,
        ]);

        // Attach foods
        foreach ($validated['foods'] as $food) {
            $meal->foods()->attach($food['food_id'], [
                'quantity' => $food['quantity'],
                'unit' => $food['unit'],
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => $meal->load('foods'),
            'message' => 'Meal logged successfully',
        ], 201);
    }

    /**
     * Get meals for a specific date
     */
    public function dailyMeals(Request $request)
    {
        $date = $request->get('date', now()->toDateString());

        $meals = $request->user()->meals()
            ->with('foods')
            ->byDate($date)
            ->get();

        // Calculate total nutrition
        $totals = [
            'calories' => 0,
            'protein' => 0,
            'carbs' => 0,
            'fat' => 0,
        ];

        foreach ($meals as $meal) {
            $nutrition = $meal->getTotalNutrition();
            $totals['calories'] += $nutrition['calories'];
            $totals['protein'] += $nutrition['protein'];
            $totals['carbs'] += $nutrition['carbs'];
            $totals['fat'] += $nutrition['fat'];
        }

        return response()->json([
            'success' => true,
            'data' => [
                'meals' => $meals,
                'totals' => $totals,
            ],
        ]);
    }

    /**
     * Update a meal
     */
    public function update(Request $request, $id)
    {
        $meal = Meal::findOrFail($id);

        if ($meal->user_id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
            ], 403);
        }

        $validated = $request->validate([
            'meal_type' => 'sometimes|in:breakfast,lunch,dinner,snack',
            'date' => 'sometimes|date',
            'time' => 'nullable|date_format:H:i',
            'notes' => 'nullable|string',
        ]);

        $meal->update($validated);

        return response()->json([
            'success' => true,
            'data' => $meal->load('foods'),
            'message' => 'Meal updated successfully',
        ]);
    }

    /**
     * Delete a meal
     */
    public function destroy(Request $request, $id)
    {
        $meal = Meal::findOrFail($id);

        if ($meal->user_id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
            ], 403);
        }

        $meal->delete();

        return response()->json([
            'success' => true,
            'message' => 'Meal deleted successfully',
        ]);
    }
}
