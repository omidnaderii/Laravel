<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;


class AttachmentFactory extends Factory
{
    
    public function definition(): array
    {
        $isImage = fake()->boolean(70); 
        $fileMake = $isImage  ? fake()->randomElement(['jpg', 'png', 'gif']) : fake()->randomElement(['mp4', 'mov', 'avi']);

        
        return [
           "post_id"=>Post::factory(),
           "file_path"=> 'attachments/' . fake()->unique()->word ."." . $fileMake,
           "type"=> $isImage ? "image": "video"
        ];
    }

public function forPost(Post $post): static
{
    return $this->state([
        'post_id' => $post->id,
    ]);
}

}
