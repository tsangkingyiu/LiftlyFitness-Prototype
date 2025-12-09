<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\WorkoutSession;
use App\Models\Workout;
use Illuminate\Http\Request;

class WorkoutSessionController extends Controller
{
    /**
     * Start a new workout session
     */
    public function start(Request $request)
    {
        $validated = $request->validate([
            'workout_id' => 'nullable|exists:workouts,id',
            'started_at' => 'nullable|date',
        ]);

        $session = $request->user()->workoutSessions()->create([
            'workout_id' => $validated['workout_id'] ?? null,
            'started_at' => $validated['started_at'] ?? now(),
            'status' => 'in_progress',
        ]);

        // Increment workout usage
        if (isset($validated['workout_id'])) {
            $workout = Workout::find($validated['workout_id']);
            $workout->incrementTimesUsed();
        }

        return response()->json([
            'success' => true,
            'data' => $session->load('workout'),
            'message' => 'Workout session started',
        ], 201);
    }

    /**
     * Complete a workout session
     */
    public function complete(Request $request, $id)
    {
        $session = WorkoutSession::findOrFail($id);

        if ($session->user_id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
            ], 403);
        }

        $validated = $request->validate([
            'completed_at' => 'nullable|date',
            'calories_burned' => 'nullable|integer',
            'notes' => 'nullable|string',
            'exercises' => 'nullable|array',
        ]);

        $session->complete();
        
        if (isset($validated['calories_burned'])) {
            $session->update(['calories_burned' => $validated['calories_burned']]);
        }

        if (isset($validated['notes'])) {
            $session->update(['notes' => $validated['notes']]);
        }

        return response()->json([
            'success' => true,
            'data' => $session,
            'message' => 'Workout completed successfully',
        ]);
    }

    /**
     * Get user's workout history
     */
    public function history(Request $request)
    {
        $query = $request->user()->workoutSessions()
            ->with(['workout', 'exercises'])
            ->completed();

        if ($request->has('from') && $request->has('to')) {
            $query->whereBetween('started_at', [$request->from, $request->to]);
        }

        $sessions = $query->orderBy('started_at', 'desc')
            ->paginate($request->get('per_page', 20));

        return response()->json([
            'success' => true,
            'data' => $sessions,
        ]);
    }
}
