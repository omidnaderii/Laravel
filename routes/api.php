<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\ParseFormData;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\CommentController;


Route::post('/register', [AuthController::class, 'register']); 
Route::post('login', [AuthController::class, 'login']);
    

// Auth needs
Route::middleware('auth:sanctum')->group(function () {

    
    

    //Connect to Posts
    Route::post('/posts', [PostController::class, 'create']);           
    Route::delete('/posts/{id}', [PostController::class, 'delete']);    
    Route::put('/post/{id}', [PostController::class, 'updatepost']);
    //->middleware(ParseFormData::class);
    Route::get('/posts', [PostController::class, 'getAllPosts']);      


    //Connect to Likes
    Route::post('/posts/{postId}/like', [LikeController::class, 'like']);       
    Route::delete('/posts/{postId}/unlike', [LikeController::class, 'unlike']); 
    Route::get('/users/{id}/liked-posts', [PostController::class, 'totalPostsLikedByUser']);

    //Connect to Comments
    Route::post('/posts/{postId}/comments', [CommentController::class, 'create']); 
    Route::delete('/comments/{id}', [CommentController::class, 'delete']);       

    //Conect to Followers
    Route::post('/users/{id}/follow', [FollowController::class, 'follow']); 
    Route::delete('/users/{id}/unfollow', [FollowController::class, 'unfollow']); 
    Route::get('/users/{id}/followers', [FollowController::class, 'followersList']);
    Route::get('/users/{id}/following', [FollowController::class, 'followingList']); 

});


