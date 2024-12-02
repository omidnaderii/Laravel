<?php

namespace App\Http\Controllers;


use App\Models\Post;
use App\Models\User;
use App\Models\Attachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class PostController extends Controller
{
    
    
    //create post
    public function create(Request $request) {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'nullable|string',
            'attachments.*' => 'file|max:2048|mimes:jpg,jpeg,png,mp4,mov',
        ]);
       
        $post = Auth::user()->posts()->create([
            'title' => $data['title'],
            'body' => $data['body'] ?? null,
        ]);

        //upload file to storage
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('attachments', 'public');
                $type = in_array($file->extension(), ['jpg', 'jpeg', 'png']) ? 'image' : 'video';

                $post->attachments()->create([
                    'file_path' => $path,
                    'type' => $type,
                ]);
            }
        }

        return response(['post' => $post->load('attachments')], 201);
    }

    

    //delete post
    public function delete($id) {
        $post = Post::with('attachments')->find($id);
    
        if (!$post || $post->user_id != Auth::id()) {
            return response(['error' => 'Unauthorized'], 403);
        }
    
    
        foreach ($post->attachments as $attachment) {
            if (Storage::disk('public')->exists($attachment->file_path)) {
                Storage::disk('public')->delete($attachment->file_path);
            }
        }
    
       
        $post->delete();
        return response(['message' => 'Post deleted'], 200);
    }
    
    
    //update post
    public function updatepost(Request $request, $postId) {
        
        $post = Post::with('attachments')->find($postId);
       
        if (!$post) {
            return response(['error' => 'Post not found'], 404);
        }
        if ($post->user_id !== Auth::id()) {
            return response(['error' => 'Unauthorized'], 403);
        }
    
       
            $data = $request->validate([
                'title' => 'required|string|max:255',
                'body' => 'nullable|string',
                'attachments.*' => 'file|max:2048|mimes:jpg,jpeg,png,mp4,mov',
            ]);


        $post->update([
            'title' => $data['title'],
            'body' => $data['body'] ?? $post->body,
        ]);
        if ($request->hasFile('attachments')) {
            foreach ($post->attachments as $attachment) {
                Storage::disk('public')->delete($attachment->file_path);
                $attachment->delete();
            }
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('attachments', 'public');
                $type = in_array($file->extension(), ['jpg', 'jpeg', 'png']) ? 'image' : 'video';
    
                $post->attachments()->create([
                    'file_path' => $path,
                    'type' => $type,
                ]);
            }
        }
    
        return response(['message' => 'Post updated successfully', 'post' => $post->load('attachments')], 200);
    }
    
    

    
    //get all posts
    public function getAllPosts() {
        $posts = Auth::user()->posts()->with('attachments')->get();
        $allPosts = $posts->map(function ($post) {
            return [
                'title' => $post->title,
                'body' => $post->body,
            ];
        });
    
        return response(['posts' => $allPosts], 200);
    }


    //get all likes
    public function totalPostsLikedByUser($userId) {
        $user = User::find($userId);
    
        if (!$user) {
            return response(['error' => 'User not found'], 404);
        }

        $totalLikes = $user->likedposts()->count();
    

        return response(['total_liked_posts' => $totalLikes], 200);
    }
    
    

}
