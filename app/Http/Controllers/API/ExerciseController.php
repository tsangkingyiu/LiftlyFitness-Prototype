<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Exercise;
use Illuminate\Http\Request;

class ExerciseController extends Controller
{
    /**
     * Display a listing of exercises
     */
    public function index(Request $request)
    {
        $query = Exercise::active();

        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter by category
        if ($request->has('category')) {
            $query->byCategory($request->category);
        }

        // Filter by muscle group
        if ($request->has('muscle_group')) {
            $query->byMuscleGroup($request->muscle_group);
        }

        // Filter by difficulty
        if ($request->has('difficulty')) {
            $query->byDifficulty($request->difficulty);
        }

        // Filter by equipment
        if ($request->has('equipment')) {
            $query->where('equipment', $request->equipment);
        }

        $exercises = $query->paginate($request->get('per_page', 20));

        return response()->json([
            'success' => true,
            'data' => $exercises,
        ]);
    }

    /**
     * Display the specified exercise
     */
    public function show($id)
    {
        $exercise = Exercise::findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $exercise,
        ]);
    }

    /**
     * Get exercise categories
     */
    public function categories()
    {
        $categories = Exercise::select('category')
            ->distinct()
            ->pluck('category');

        return response()->json([
            'success' => true,
            'data' => $categories,
        ]);
    }

    /**
     * Get muscle groups
     */
    public function muscleGroups()
    {
        $muscleGroups = Exercise::select('muscle_group')
            ->distinct()
            ->pluck('muscle_group');

        return response()->json([
            'success' => true,
            'data' => $muscleGroups,
        ]);
    }
}
