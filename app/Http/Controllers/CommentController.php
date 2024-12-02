<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    //create comment
    public function create(Request $request, $postId) {

        $post = Post::find($postId);
        if (!$post) {
            return response()->json(['error' => 'Post not found'], 404);
        }
       
        $data = $request->validate([
            'comment' => 'required|string|max:500',
        ]);
    
        
        $comment = $post->comments()->create([
            'user_id' => Auth::id(),
            'comment' => $data['comment'],
        ]);
    
        return response(['comment' => $comment], 201);
    }

    
    //delete comment
    public function delete($id) {
        $comment = Comment::find($id);

        if (!$comment || $comment->user_id != Auth::id()) {
            return response(['error' => 'Unauthorized'], 403);
        }

        $comment->delete();

        return response(['message' => 'Comment deleted'], 200);
    }
}
