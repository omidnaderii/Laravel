<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;


class LikeFactory extends Factory
{
    
    public function definition(): array
    {
        return [
            "user_id"=> User ::factory(),
            "post_id"=>Post::factory()
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
