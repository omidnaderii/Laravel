<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Post;
use App\Models\Attachment;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;

class PostUpdateFeatureTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_can_update_a_post_with_attachments()
    {
        Storage::fake('public');
        $user = User::factory()->create();
        $this->actingAs($user, 'sanctum');

        $post = Post::factory()->create([
            'user_id' => $user->id,
            'title' => 'Old Title',
            'body' => 'Old Body',
        ]);
        $oldAttachment = Attachment::factory()->create([
            'post_id' => $post->id,
            'file_path' => 'attachments/old_file.jpg',
            'type' => 'image',
        ]);

        $newFile = UploadedFile::fake()->image('new_file.jpg');

        $response = $this->putJson("/api/post/{$post->id}", [
            'title' => 'Updated Title',
            'body' => 'Updated Body',
            'attachments' => [$newFile],
        ]);

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Post updated successfully']);

      

        $this->assertDatabaseHas('attachments', [
            'post_id' => $post->id,
            'file_path' => 'attachments/' . $newFile->hashName(),
            'type' => 'image',
        ]);
    }

    #[Test]
    public function it_can_update_a_post_without_attachments()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'sanctum');

        $post = Post::factory()->create([
            'user_id' => $user->id,
            'title' => 'Old Title',
            'body' => 'Old Body',
        ]);
        $oldAttachment = Attachment::factory()->create([
            'post_id' => $post->id,
            'file_path' => 'attachments/old_file.jpg',
            'type' => 'image',
        ]);

        $response = $this->put("/api/post/{$post->id}", [
            'title' => 'Updated Title',
            'body' => 'Updated Body',
            'attachments' => [],
        ]);

        $response->assertStatus(200)
                 ->assertJson([
                     'message' => 'Post updated successfully',
                     'post' => [
                         'title' => 'Updated Title',
                         'body' => 'Updated Body',
                        
                     ],
                 ]);

        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'title' => 'Updated Title',
            'body' => 'Updated Body',
            
        ]);
    }

    #[Test]
    public function it_returns_404_if_post_not_found()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'sanctum');

        $response = $this->putJson('/api/post/999', ['title' => 'New Title']);

        $response->assertStatus(404)
                 ->assertJson(['error' => 'Post not found']);
    }

    #[Test]
    public function it_returns_403_if_user_is_not_authorized()
    {
        $post = Post::factory()->create();
        $unauthorizedUser = User::factory()->create();
        $this->actingAs($unauthorizedUser, 'sanctum');

        $response = $this->putJson("/api/post/{$post->id}", ['title' => 'New Title']);

        $response->assertStatus(403)
                 ->assertJson(['error' => 'Unauthorized']);
    }
}
