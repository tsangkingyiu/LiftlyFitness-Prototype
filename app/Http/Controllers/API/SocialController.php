<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Activity;
use Illuminate\Http\Request;

class SocialController extends Controller
{
    /**
     * Follow a user
     */
    public function follow(Request $request, $userId)
    {
        $userToFollow = User::findOrFail($userId);

        if ($userToFollow->id === $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'You cannot follow yourself',
            ], 400);
        }

        $request->user()->follow($userToFollow);

        return response()->json([
            'success' => true,
            'message' => 'User followed successfully',
        ]);
    }

    /**
     * Unfollow a user
     */
    public function unfollow(Request $request, $userId)
    {
        $userToUnfollow = User::findOrFail($userId);
        $request->user()->unfollow($userToUnfollow);

        return response()->json([
            'success' => true,
            'message' => 'User unfollowed successfully',
        ]);
    }

    /**
     * Get user's followers
     */
    public function followers(Request $request, $userId = null)
    {
        $user = $userId ? User::findOrFail($userId) : $request->user();
        $followers = $user->followers()->paginate(20);

        return response()->json([
            'success' => true,
            'data' => $followers,
        ]);
    }

    /**
     * Get user's following
     */
    public function following(Request $request, $userId = null)
    {
        $user = $userId ? User::findOrFail($userId) : $request->user();
        $following = $user->following()->paginate(20);

        return response()->json([
            'success' => true,
            'data' => $following,
        ]);
    }

    /**
     * Get activity feed
     */
    public function feed(Request $request)
    {
        $followingIds = $request->user()->following()->pluck('users.id');
        $followingIds[] = $request->user()->id; // Include user's own activities

        $activities = Activity::with(['user', 'activityable'])
            ->whereIn('user_id', $followingIds)
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return response()->json([
            'success' => true,
            'data' => $activities,
        ]);
    }

    /**
     * Like an activity
     */
    public function likeActivity(Request $request, $activityId)
    {
        $activity = Activity::findOrFail($activityId);
        $activity->like($request->user());

        return response()->json([
            'success' => true,
            'message' => 'Activity liked',
        ]);
    }

    /**
     * Unlike an activity
     */
    public function unlikeActivity(Request $request, $activityId)
    {
        $activity = Activity::findOrFail($activityId);
        $activity->unlike($request->user());

        return response()->json([
            'success' => true,
            'message' => 'Activity unliked',
        ]);
    }

    /**
     * Comment on an activity
     */
    public function commentActivity(Request $request, $activityId)
    {
        $validated = $request->validate([
            'comment' => 'required|string|max:500',
        ]);

        $activity = Activity::findOrFail($activityId);
        $comment = $activity->comments()->create([
            'user_id' => $request->user()->id,
            'comment' => $validated['comment'],
        ]);

        $activity->increment('comments_count');

        return response()->json([
            'success' => true,
            'data' => $comment->load('user'),
            'message' => 'Comment added',
        ], 201);
    }
}
