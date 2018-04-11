<?php

use App\Post;

class PostTest extends TestCase
{
    public function testGetPosts()
    {
        $user = factory(App\User::class)->create();
        $post = factory(App\Post::class)->create([
            'user_id' => $user->id
        ]);
        $this->json('GET', '/posts')
            ->seeStatusCode(200)
            ->seeJsonEquals([$post->toArray()]);
    }

    public function testGetPost()
    {
        $user = factory(App\User::class)->create();
        $post = factory(App\Post::class)->create([
            'user_id' => $user->id
        ]);
        $this->get('/posts/' . $post->id)
            ->seeStatusCode(200)
            ->seeJsonEquals($post->toArray());
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
        $newText = str_random(300);

        $this->put('/posts/' . $post->id, ["text" => $newText])
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
        $sampleText = str_random(300);

        $this->post('/posts', ['text' => $sampleText])
            ->seeStatusCode(401);
        $this->notSeeInDatabase('posts', ['user_id' => $user->id, 'text' => $sampleText]);

        $this->actingAs($user);
        $this->post('/posts', ['text' => $sampleText])
            ->seeStatusCode(200);
        $this->seeInDatabase('posts', ['user_id' => $user->id, 'text' => $sampleText]);
    }
}
