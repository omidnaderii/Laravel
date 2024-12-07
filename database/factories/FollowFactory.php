<?php

namespace Database\Factories;

use Illuminate\Support\Facades\Log;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;


class FollowFactory extends Factory
{
       public function definition(): array
        {
            Log::info('in The class here');
            return [
                'follower_id' => User::factory(),
                'following_id' => User::factory(),
            ];
        }
    
        public function forUsers(User $follower, User $following): static
        {
            return $this->state([
                'follower_id' => $follower->id,
                'following_id' => $following->id,
            ]);
        }
    }
    
