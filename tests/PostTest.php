<?php

use App\Post;
use App\User;
use Illuminate\Support\Str;

/**
 * @internal
 */
class PostTest extends TestCase
{
    public function testGetPosts()
    {
        $user = factory(User::class)->create();
        $post = factory(Post::class)->create([
            'user_id' => $user->id,
        ]);
        $result = Post::find($post->id);

        $this->get('posts')
            ->seeStatusCode(200)
            ->seeJsonEquals([$result->toArray()]);
    }

    public function testGetPost()
    {
        $user = factory(User::class)->create();
        $post = factory(Post::class)->create([
            'user_id' => $user->id,
        ]);
        $result = Post::find($post->id);

        $this->get('posts/' . $post->id)
            ->seeStatusCode(200)
            ->seeJsonEquals($result->toArray());
    }

    public function testGetNotExistingPost()
    {
        $this->get('posts/1')
            ->seeStatusCode(404);
    }

    public function testPostEdit()
    {
        $user = factory(User::class)->create();
        $post = factory(Post::class)->create([
            'user_id' => $user->id,
        ]);
        $newText = Str::random(300);

        $this->put('posts/' . $post->id, ['text' => $newText])
            ->seeStatusCode(401);

        $this->notSeeInDatabase('posts', ['id' => $post->id, 'text' => $newText]);

        $this->actingAs($user);
        $this->put('posts/' . $post->id, ['text' => $newText])
            ->seeStatusCode(200);

        $this->put('posts/' . ($post->id + 1), ['text' => $newText])
            ->seeStatusCode(404);

        $this->seeInDatabase('posts', ['id' => $post->id, 'text' => $newText]);
    }

    public function testPostDelete()
    {
        $user = factory(User::class)->create();
        $post = factory(Post::class)->create([
            'user_id' => $user->id,
        ]);

        $this->delete('posts/' . $post->id)
            ->seeStatusCode(401);
        $this->seeInDatabase('posts', ['id' => $post->id]);

        $this->actingAs($user);
        $this->delete('posts/' . $post->id)
            ->seeStatusCode(200);
        $this->notSeeInDatabase('posts', ['id' => $post->id]);

        $this->delete('posts/1')
            ->seeStatusCode(404);
    }

    public function testPostNew()
    {
        $user = factory(User::class)->create();
        $sampleText = Str::random(300);

        $this->post('posts', ['text' => $sampleText, 'title' => 'tit'])
            ->seeStatusCode(401);
        $this->notSeeInDatabase('posts', ['user_id' => $user->id, 'text' => $sampleText]);

        $this->actingAs($user);
        $this->post('posts', ['text' => $sampleText, 'title' => 'tit'])
            ->seeStatusCode(200);
        $this->seeInDatabase('posts', ['user_id' => $user->id, 'text' => $sampleText]);
    }

    public function testPostCoverage()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);
        $post = factory(Post::class)->create([
            'user_id' => $user->id,
        ]);

        $this->assertEquals([$user->toArray()], $post->user()->get()->toArray());
    }

    public function testPostNewValidation()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);

        $this->post('posts')
            ->seeStatusCode(422);
        $this->notSeeInDatabase('posts', ['user_id' => $user->id]);

        $this->post('posts', ['title' => 'tit'])
            ->seeStatusCode(422);
        $this->notSeeInDatabase('posts', ['user_id' => $user->id]);

        $this->post('posts', ['text' => 'txt'])
            ->seeStatusCode(422);
        $this->notSeeInDatabase('posts', ['user_id' => $user->id]);

        $this->post('posts', ['title' => 'tit', 'text' => 'txt'])
            ->seeStatusCode(200);
        $this->seeInDatabase('posts', ['user_id' => $user->id, 'text' => 'txt', 'title' => 'tit']);
    }
}
