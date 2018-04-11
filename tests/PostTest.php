<?php

use App\Post;

class PostTest extends TestCase
{
    public function testGetPosts()
    {
        /* get all posts */
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
        /* get single post */
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
        $text = str_random(300);

        $this->put('/posts/' . $post->id, ["text" => $text])
            ->seeStatusCode(401);

        $this->notSeeInDatabase('posts', ['id' => $post->id, 'text' => $text]);

        $this->actingAs($user);
        $this->put('/posts/' . $post->id, ["text" => $text])
            ->seeStatusCode(200);

        $this->seeInDatabase('posts', ['id' => $post->id, 'text' => $text]);
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
}
