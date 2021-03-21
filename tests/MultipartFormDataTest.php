<?php

use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Str;

class MultipartFormDataTest extends TestCase
{
    public function testMultipartPutRequest()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create([
            'user_id' => $user->id,
        ]);
        $newText = Str::random(300);

        $this->actingAs($user);
        $this->put(
            'posts/' . $post->id,
            ['text' => $newText],
            ['Content-Type' => 'multipart/form-data']
        )
            ->seeStatusCode(200);
    }
}
