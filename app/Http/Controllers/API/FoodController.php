<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Food;
use Illuminate\Http\Request;

class FoodController extends Controller
{
    /**
     * Search foods
     */
    public function index(Request $request)
    {
        $query = Food::query();

        // Search
        if ($request->has('search')) {
            $query->search($request->search);
        }

        // Filter verified foods
        if ($request->boolean('verified')) {
            $query->verified();
        }

        $foods = $query->paginate($request->get('per_page', 20));

        return response()->json([
            'success' => true,
            'data' => $foods,
        ]);
    }

    /**
     * Get food details
     */
    public function show($id)
    {
        $food = Food::findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $food,
        ]);
    }

    /**
     * Create custom food
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'brand' => 'nullable|string|max:255',
            'serving_size' => 'required|numeric|min:0',
            'serving_unit' => 'required|string|max:50',
            'calories' => 'required|numeric|min:0',
            'protein' => 'required|numeric|min:0',
            'carbs' => 'required|numeric|min:0',
            'fat' => 'required|numeric|min:0',
            'fiber' => 'nullable|numeric|min:0',
            'sugar' => 'nullable|numeric|min:0',
        ]);

        $food = Food::create(array_merge($validated, [
            'created_by' => $request->user()->id,
            'is_verified' => false,
        ]));

        return response()->json([
            'success' => true,
            'data' => $food,
            'message' => 'Food created successfully',
        ], 201);
    }
}
