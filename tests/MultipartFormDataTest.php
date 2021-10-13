<?php

use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Str;

/**
 * @internal
 */
class MultipartFormDataTest extends TestCase
{
    public function testMultipartPutRequest()
    {
        /** @var User $user */
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
