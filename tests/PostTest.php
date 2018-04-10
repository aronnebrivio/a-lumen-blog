<?php

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
            ->seeStatusCode(404)
            ->seeJsonEquals($post->toArray());
    }
}