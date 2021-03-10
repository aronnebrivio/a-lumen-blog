<?php

use App\Comment;
use App\Post;
use App\User;
use Illuminate\Support\Str;

/**
 * @internal
 */
class CommentTest extends TestCase
{
    public function testGetCommentsByPostId()
    {
        $user = factory(User::class)->create();
        $post = factory(Post::class)->create([
            'user_id' => $user->id,
        ]);

        $comment = factory(Comment::class)->create([
            'user_id' => $user->id,
            'post_id' => $post->id,
        ]);

        $result = Comment::find($comment->id);

        $this->json('GET', 'comments', ['post_id' => $post->id])
            ->seeStatusCode(200)
            ->seeJsonEquals([$result->toArray()]);
    }

    public function testCommentEdit()
    {
        $user = factory(User::class)->create();
        $user2 = factory(User::class)->create();
        $post = factory(Post::class)->create([
            'user_id' => $user->id,
        ]);
        $comment = factory(Comment::class)->create([
            'user_id' => $user->id,
            'post_id' => $post->id,
        ]);
        $comment2 = factory(Comment::class)->create([
            'user_id' => $user2->id,
            'post_id' => $post->id,
        ]);
        $newText = Str::random(300);

        $this->put('comments/' . $comment->id, ['text' => $newText])
            ->seeStatusCode(401);

        $this->notSeeInDatabase('comments', ['id' => $comment->id, 'text' => $newText]);

        $this->actingAs($user);
        $this->put('comments/' . $comment->id, ['text' => $newText])
            ->seeStatusCode(200);

        $this->put('comments/' . ($comment->id + 2), ['text' => $newText])
            ->seeStatusCode(404);

        $this->seeInDatabase('comments', ['id' => $comment->id, 'text' => $newText]);

        $user2 = factory(User::class)->create();
        $comment2 = factory(Comment::class)->create([
            'user_id' => $user2->id,
            'post_id' => $post->id,
        ]);
        $this->put('comments/' . $comment2->id, ['text' => $newText])
            ->seeStatusCode(401);
    }

    public function testCommentDelete()
    {
        $user = factory(User::class)->create();
        $user2 = factory(User::class)->create();
        $post = factory(Post::class)->create([
            'user_id' => $user->id,
        ]);
        $comment = factory(Comment::class)->create([
            'user_id' => $user->id,
            'post_id' => $post->id,
        ]);
        $comment2 = factory(Comment::class)->create([
            'user_id' => $user2->id,
            'post_id' => $post->id,
        ]);

        $this->delete('comments/' . $comment->id)
            ->seeStatusCode(401);
        $this->seeInDatabase('comments', ['id' => $comment->id]);

        $this->actingAs($user);
        $this->delete('comments/' . $comment->id)
            ->seeStatusCode(200);
        $this->notSeeInDatabase('comments', ['id' => $comment->id]);

        $this->delete('comments/' . 1)
            ->seeStatusCode(404);

        $this->delete('comments/' . $comment2->id)
            ->seeStatusCode(401);
    }

    public function testCommentNew()
    {
        $user = factory(User::class)->create();
        $post = factory(Post::class)->create([
            'user_id' => $user->id,
        ]);
        $sampleText = Str::random(300);

        $this->post('comments', ['post_id' => $post->id, 'text' => $sampleText])
            ->seeStatusCode(401);
        $this->notSeeInDatabase('comments', ['user_id' => $user->id, 'post_id' => $post->id, 'text' => $sampleText]);

        $this->actingAs($user);
        $this->post('comments', ['post_id' => $post->id, 'text' => $sampleText])
            ->seeStatusCode(200);
        $this->seeInDatabase('comments', ['user_id' => $user->id, 'post_id' => $post->id, 'text' => $sampleText]);
    }

    public function testCommentCoverage()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);
        $post = factory(Post::class)->create([
            'user_id' => $user->id,
        ]);
        $comment = factory(Comment::class)->create([
            'post_id' => $post->id,
            'user_id' => $user->id,
        ]);
        $post = Post::find($post->id);

        $this->assertEquals([$user->toArray()], $comment->user()->get()->toArray());
        $this->assertEquals([$post->toArray()], $comment->post()->get()->toArray());
    }

    public function testCommentNewValidation()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);
        $post = factory(Post::class)->create([
            'user_id' => $user->id,
        ]);

        $this->post('comments', ['post_id' => $post->id])
            ->seeStatusCode(422);
        $this->notSeeInDatabase('comments', ['user_id' => $user->id, 'post_id' => $post->id]);

        $this->post('comments', ['post_id' => $post->id, 'text' => 'txt'])
            ->seeStatusCode(200);
        $this->seeInDatabase('comments', ['user_id' => $user->id, 'text' => 'txt', 'post_id' => $post->id]);
    }
}
