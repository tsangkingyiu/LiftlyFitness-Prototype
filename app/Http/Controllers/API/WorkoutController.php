<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Workout;
use Illuminate\Http\Request;

class WorkoutController extends Controller
{
    /**
     * Display a listing of workouts
     */
    public function index(Request $request)
    {
        $query = Workout::with(['user', 'exercises']);

        // Filter by category
        if ($request->has('category')) {
            $query->byCategory($request->category);
        }

        // Filter by public/private
        if ($request->has('public')) {
            $query->where('is_public', $request->boolean('public'));
        } else {
            // Default: show user's workouts + public workouts
            $query->where(function ($q) use ($request) {
                $q->where('user_id', $request->user()->id)
                  ->orWhere('is_public', true);
            });
        }

        // Sort
        if ($request->has('sort')) {
            $order = $request->get('order', 'desc');
            $query->orderBy($request->sort, $order);
        }

        $workouts = $query->paginate($request->get('per_page', 20));

        return response()->json([
            'success' => true,
            'data' => $workouts,
        ]);
    }

    /**
     * Store a newly created workout
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:100',
            'duration' => 'nullable|integer',
            'difficulty' => 'nullable|in:beginner,intermediate,advanced',
            'is_public' => 'boolean',
            'exercises' => 'required|array|min:1',
            'exercises.*.exercise_id' => 'required|exists:exercises,id',
            'exercises.*.order' => 'required|integer',
            'exercises.*.sets' => 'nullable|integer',
            'exercises.*.reps' => 'nullable|integer',
            'exercises.*.duration' => 'nullable|integer',
            'exercises.*.rest' => 'nullable|integer',
            'exercises.*.notes' => 'nullable|string',
        ]);

        $workout = $request->user()->workouts()->create([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'category' => $validated['category'] ?? null,
            'duration' => $validated['duration'] ?? null,
            'difficulty' => $validated['difficulty'] ?? null,
            'is_public' => $validated['is_public'] ?? false,
        ]);

        // Attach exercises
        foreach ($validated['exercises'] as $exercise) {
            $workout->exercises()->attach($exercise['exercise_id'], [
                'order' => $exercise['order'],
                'sets' => $exercise['sets'] ?? null,
                'reps' => $exercise['reps'] ?? null,
                'duration' => $exercise['duration'] ?? null,
                'rest' => $exercise['rest'] ?? 60,
                'notes' => $exercise['notes'] ?? null,
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => $workout->load('exercises'),
            'message' => 'Workout created successfully',
        ], 201);
    }

    /**
     * Display the specified workout
     */
    public function show($id)
    {
        $workout = Workout::with(['user', 'exercises'])->findOrFail($id);

        // Check access
        if (!$workout->is_public && $workout->user_id !== auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access',
            ], 403);
        }

        return response()->json([
            'success' => true,
            'data' => $workout,
        ]);
    }

    /**
     * Update the specified workout
     */
    public function update(Request $request, $id)
    {
        $workout = Workout::findOrFail($id);

        // Check ownership
        if ($workout->user_id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
            ], 403);
        }

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:100',
            'duration' => 'nullable|integer',
            'difficulty' => 'nullable|in:beginner,intermediate,advanced',
            'is_public' => 'boolean',
        ]);

        $workout->update($validated);

        return response()->json([
            'success' => true,
            'data' => $workout->load('exercises'),
            'message' => 'Workout updated successfully',
        ]);
    }

    /**
     * Remove the specified workout
     */
    public function destroy(Request $request, $id)
    {
        $workout = Workout::findOrFail($id);

        if ($workout->user_id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
            ], 403);
        }

        $workout->delete();

        return response()->json([
            'success' => true,
            'message' => 'Workout deleted successfully',
        ]);
    }
}
