<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\WorkoutController;
use App\Http\Controllers\API\ExerciseController;
use App\Http\Controllers\API\WorkoutSessionController;
use App\Http\Controllers\API\MealController;
use App\Http\Controllers\API\FoodController;
use App\Http\Controllers\API\SocialController;

/*
|--------------------------------------------------------------------------
| API Routes - Version 1
|--------------------------------------------------------------------------
*/

Route::prefix('v1')->group(function () {

    // Public routes
    Route::post('/auth/register', [AuthController::class, 'register']);
    Route::post('/auth/login', [AuthController::class, 'login']);

    // Protected routes
    Route::middleware('auth:sanctum')->group(function () {
        
        // Auth
        Route::post('/auth/logout', [AuthController::class, 'logout']);
        Route::get('/auth/me', [AuthController::class, 'me']);

        // Exercises
        Route::get('/exercises', [ExerciseController::class, 'index']);
        Route::get('/exercises/{id}', [ExerciseController::class, 'show']);
        Route::get('/exercises/meta/categories', [ExerciseController::class, 'categories']);
        Route::get('/exercises/meta/muscle-groups', [ExerciseController::class, 'muscleGroups']);

        // Workouts
        Route::apiResource('workouts', WorkoutController::class);
        
        // Workout Sessions
        Route::post('/workout-sessions/start', [WorkoutSessionController::class, 'start']);
        Route::post('/workout-sessions/{id}/complete', [WorkoutSessionController::class, 'complete']);
        Route::get('/workout-sessions/history', [WorkoutSessionController::class, 'history']);

        // Foods
        Route::get('/foods', [FoodController::class, 'index']);
        Route::get('/foods/{id}', [FoodController::class, 'show']);
        Route::post('/foods', [FoodController::class, 'store']);

        // Meals
        Route::post('/meals', [MealController::class, 'store']);
        Route::get('/meals/daily', [MealController::class, 'dailyMeals']);
        Route::put('/meals/{id}', [MealController::class, 'update']);
        Route::delete('/meals/{id}', [MealController::class, 'destroy']);

        // Social
        Route::post('/social/follow/{userId}', [SocialController::class, 'follow']);
        Route::post('/social/unfollow/{userId}', [SocialController::class, 'unfollow']);
        Route::get('/social/followers/{userId?}', [SocialController::class, 'followers']);
        Route::get('/social/following/{userId?}', [SocialController::class, 'following']);
        Route::get('/social/feed', [SocialController::class, 'feed']);
        Route::post('/social/activities/{activityId}/like', [SocialController::class, 'likeActivity']);
        Route::delete('/social/activities/{activityId}/like', [SocialController::class, 'unlikeActivity']);
        Route::post('/social/activities/{activityId}/comments', [SocialController::class, 'commentActivity']);
    });
});
