<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;


class CommentFactory extends Factory
{
   
    public function definition(): array
    {
        return [
           'user_id'=>User::factory(),
           'post_id'=>Post::factory(),
           'comment'=>fake()->sentence()
        ];
    }
    public function forPostandUser(Post $post , User $user): static
    {
        return $this->state([
            "user_id"=> $user->id,
            "post_id"=> $post->id,
        ]);

    }
}