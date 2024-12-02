<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'title', 'body'];

    //who has post
    public function user() {
        return $this->belongsTo(User::class);
    }

   //connect to attachments
    public function attachments() {
        return $this->hasMany(Attachment::class);
    }

    //connect to commends of users
    public function comments() {
        return $this->hasMany(Comment::class);
    }

    //connect to likes
    public function likes() {
        return $this->hasMany(Like::class);
    }
}
