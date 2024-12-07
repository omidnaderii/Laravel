<?php

namespace Database\Factories;


use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;


class PostFactory extends Factory
{
  
    public function definition(): array
    {
        return [
           'user_id'=>User::factory(),
           'title'=>fake()->sentence(),
           'body'=>fake()->paragraph()
        ];
    }
    public function forUser(User $user): static
    {
        return $this->state([
            "user_id"=> $user->id,
           
        ]);

    }
}
