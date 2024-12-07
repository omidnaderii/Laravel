<?php

namespace Database\Seeders;

use App\Models\Like;
use App\Models\Post;
use App\Models\User;
use App\Models\Follow;
use App\Models\Comment;
use App\Models\Attachment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class DatabaseSeeder extends Seeder
{
    
    public function run(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->forUser($user)->create();
        Comment::factory()->forPostandUser($post,$user)->create();
        Like::factory()->forPostandUser($post,$user)->create();
        Attachment::factory()->forPost($post)->create();


        $follower = User::factory()->create(); 
        Follow::factory()->forUsers($follower, $user)->create(); 
       
        $following = User::factory()->create(); 
        Follow::factory()->forUsers($user, $following)->create(); 


       
    }
}
