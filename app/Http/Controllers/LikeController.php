<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{

    //do like
    public function like($postId) {
        $post = Post::find($postId);

        if (!$post) {
            return response(['error' => 'Post not found'], 404);
        }

        if ($post->likes()->where('user_id', Auth::id())->exists()) {
            return response(['error' => 'You have already liked this post'], 400);
        }

        $post->likes()->create(['user_id' => Auth::id()]);

        return response(['message' => 'Post liked'], 200);
    }

    

    //unlike
    public function unlike($postId) {
        $post = Post::find($postId);

        if (!$post) {
            return response(['error' => 'Post not found'], 404);
        }

        $like = $post->likes()->where('user_id', Auth::id())->first();

        if (!$like) {
            return response(['error' => 'You have not liked this post'], 400);
        }

        $like->delete();

        return response(['message' => 'Like removed '], 200);
    }
}
