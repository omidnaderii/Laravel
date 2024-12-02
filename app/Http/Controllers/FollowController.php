<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FollowController extends Controller
{
    

    public function follow($id) {
        $userToFollow = User::find($id);

        if (!$userToFollow) {
            return response(['error' => 'User not found'], 404);
        }

        //if didn't follow each other
        if (Auth::user()->following()->where('following_id', $id)->exists()) {
            return response(['error' => 'You are already following this user'], 400);
        }

        Auth::user()->following()->attach($id);

        return response(['message' => $userToFollow->name .' followed successfully'], 200);
    }

    
    //unfollow
    public function unfollow($id) {
        $userToUnfollow = User::find($id);

        if (!$userToUnfollow) {
            return response(['error' => 'User not found'], 404);
        }

        if (!Auth::user()->following()->where('following_id', $id)->exists()) {
            return response(['error' => 'You are not following this user'], 400);
        }

        Auth::user()->following()->detach($id);

        return response(['message' => $userToUnfollow->name .' unfollowed successfully'], 200);
    }

    
    
    //list of follower
    public function followersList($id) {
        $user = User::find($id);

        if (!$user) {
            return response(['error' => 'User not found'], 404);
        }

        return response(['followers' => $user->followers->pluck('name')], 200);
    }

    
    //list of following
    public function followingList($id) {
        $user = User::find($id);

        if (!$user) {
            return response(['error' => 'User not found'], 404);
        }

        return response(['following' => $user->following->pluck('name')], 200);
    }
}
