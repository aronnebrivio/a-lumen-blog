<?php

use App\Post;
use App\Scopes\AuthScope;
use Illuminate\Support\Str;

class PostTest extends TestCase
{
    public function testGetPosts()
    {
        $user = factory(App\User::class)->create();
        $post = factory(App\Post::class)->create([
            'user_id' => $user->id
        ]);
        $result = Post::withoutGlobalScope(AuthScope::class)->find($post->id);

        $this->json('GET', '/posts')
            ->seeStatusCode(200)
            ->seeJsonEquals([$result->toArray()]);
    }

    public function testGetPost()
    {
        $user = factory(App\User::class)->create();
        $post = factory(App\Post::class)->create([
            'user_id' => $user->id
        ]);
        $result = Post::withoutGlobalScope(AuthScope::class)->find($post->id);

        $this->get('/posts/' . $post->id)
            ->seeStatusCode(200)
            ->seeJsonEquals($result->toArray());
    }

    public function testGetNotExistingPost()
    {
        $this->get('/posts/' . 1)
            ->seeStatusCode(404);
    }

    function testPostEdit()
    {
        $user = factory(App\User::class)->create();
        $post = factory(App\Post::class)->create([
            'user_id' => $user->id
        ]);
        $newText = Str::random(300);

        $this->put('/posts/' . $post->id, ['text' => $newText])
            ->seeStatusCode(401);

        $this->notSeeInDatabase('posts', ['id' => $post->id, 'text' => $newText]);

        $this->actingAs($user);
        $this->put('/posts/' . $post->id, ["text" => $newText])
            ->seeStatusCode(200);

        $this->seeInDatabase('posts', ['id' => $post->id, 'text' => $newText]);
    }

    function testPostDelete()
    {
        $user = factory(App\User::class)->create();
        $post = factory(App\Post::class)->create([
            'user_id' => $user->id
        ]);

        $this->delete('/posts/' . $post->id)
            ->seeStatusCode(401);
        $this->seeInDatabase('posts', ['id' => $post->id]);

        $this->actingAs($user);
        $this->delete('/posts/' . $post->id)
            ->seeStatusCode(200);
        $this->notSeeInDatabase('posts', ['id' => $post->id]);

        $this->delete('/posts/' . 1)
            ->seeStatusCode(404);
    }

    function testPostNew()
    {
        $user = factory(App\User::class)->create();
        $sampleText = Str::random(300);

        $this->post('/posts', ['text' => $sampleText, 'title' => 'tit'])
            ->seeStatusCode(401);
        $this->notSeeInDatabase('posts', ['user_id' => $user->id, 'text' => $sampleText]);

        $this->actingAs($user);
        $this->post('/posts', ['text' => $sampleText, 'title' => 'tit'])
            ->seeStatusCode(200);
        $this->seeInDatabase('posts', ['user_id' => $user->id, 'text' => $sampleText]);
    }

    function testPostCoverage()
    {
        $user = factory(App\User::class)->create();
        $this->actingAs($user);
        $post = factory(App\Post::class)->create();
        $this->assertEquals([$user->toArray()], $post->user()->get()->toArray());
    }

    function testPostNewValidation()
    {
        $user = factory(App\User::class)->create();
        $this->actingAs($user);

        $this->post('/posts')
            ->seeStatusCode(422);
        $this->notSeeInDatabase('posts', ['user_id' => $user->id]);

        $this->post('/posts', ['title' => 'tit'])
            ->seeStatusCode(422);
        $this->notSeeInDatabase('posts', ['user_id' => $user->id]);


        $this->post('/posts', ['text' => 'txt'])
            ->seeStatusCode(422);
        $this->notSeeInDatabase('posts', ['user_id' => $user->id]);


        $this->post('/posts', ['title' => 'tit', 'text' => 'txt'])
            ->seeStatusCode(200);
        $this->seeInDatabase('posts', ['user_id' => $user->id, 'text' => 'txt', 'title' => 'tit']);
    }
}
