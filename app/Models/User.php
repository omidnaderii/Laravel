<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;


class User extends Authenticatable
{
    use HasFactory, Notifiable , HasApiTokens;

    protected $fillable = ['name', 'email', 'password'];

    //connect to posts
    public function posts() {
        return $this->hasMany(Post::class);
    }

   //connect to comments
    public function comments() {
        return $this->hasMany(Comment::class);
    }

    //connect to likes
    public function likes() {
        return $this->hasMany(Like::class);
    }
    public function likedposts() {
        return $this->belongsToMany(Post::class, 'likes', 'user_id', 'post_id');
    }
    

    //connect to following
    public function following() {
        return $this->belongsToMany(User::class, 'follows', 'follower_id', 'following_id');
    }

    //connect to followers
    public function followers() {
        return $this->belongsToMany(User::class, 'follows', 'following_id', 'follower_id');
    }
    

}
