<?php

class Comment extends TestCase
{
    public function testGetCommentsByPostId()
    {
        $user = factory(App\User::class)->create();
        $post = factory(App\Post::class)->create([
            'user_id' => $user->id
        ]);
        $comment = factory(App\Comment::class)->create([
            'user_id' => $user->id,
            'post_id' => $post->id
        ]);

        $this->json('GET','/comments/', ['post_id' => $post->id])
            ->seeStatusCode(200)
            ->seeJsonEquals([$comment->toArray()]);
    }

    public function testCommentsNotExistingPost()
    {
        $this->json('GET','/comments/', ['post_id' => 1])
            ->seeStatusCode(404);
    }

    function testCommentEdit()
    {
        $user = factory(App\User::class)->create();
        $post = factory(App\Post::class)->create([
            'user_id' => $user->id
        ]);
        $comment = factory(App\Comment::class)->create([
            'user_id' => $user->id,
            'post_id' => $post->id
        ]);
        $text = str_random(300);

        $this->put('/comments/' . $comment->id, ["text" => $text])
            ->seeStatusCode(401);

        $this->notSeeInDatabase('comments', ['id' => $comment->id, 'text' => $text]);

        $this->actingAs($user);
        $this->put('/comments/' . $comment->id, ["text" => $text])
            ->seeStatusCode(200);

        $this->seeInDatabase('comments', ['id' => $comment->id, 'text' => $text]);
    }

    function testCommentDelete()
    {
        $user = factory(App\User::class)->create();
        $post = factory(App\Post::class)->create([
            'user_id' => $user->id
        ]);
        $comment = factory(App\Comment::class)->create([
            'user_id' => $user->id,
            'post_id' => $post->id
        ]);

        $this->delete('/comments/' . $comment->id)
            ->seeStatusCode(401);
        $this->seeInDatabase('comments', ['id' => $comment->id]);

        $this->actingAs($user);
        $this->delete('/comments/' . $comment->id)
            ->seeStatusCode(200);
        $this->notSeeInDatabase('comments', ['id' => $comment->id]);

        $this->delete('/comments/' . 1)
            ->seeStatusCode(404);
    }
}
