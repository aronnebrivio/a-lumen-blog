<?php

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Str;

/**
 * @internal
 */
class CommentTest extends TestCase
{
    public function testGetComments()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create([
            'user_id' => $user->id,
        ]);

        $comment = Comment::factory()->create([
            'user_id' => $user->id,
            'post_id' => $post->id,
        ]);

        $result = Comment::find($comment->id);

        $this->json('GET', 'posts/' . $post->id . '/comments')
            ->seeStatusCode(200)
            ->seeJsonEquals([$result->toArray()]);
    }

    public function testCommentEdit()
    {
        $user = User::factory()->create();
        $user2 = User::factory()->create();
        $post = Post::factory()->create([
            'user_id' => $user->id,
        ]);
        $comment = Comment::factory()->create([
            'user_id' => $user->id,
            'post_id' => $post->id,
        ]);
        $comment2 = Comment::factory()->create([
            'user_id' => $user2->id,
            'post_id' => $post->id,
        ]);
        $newText = Str::random(300);

        $this->put('posts/' . $post->id . '/comments/' . $comment->id, ['text' => $newText])
            ->seeStatusCode(401);

        $this->notSeeInDatabase('comments', ['id' => $comment->id, 'text' => $newText]);

        $this->actingAs($user);
        $this->put('posts/' . ($post->id + 1) . '/comments/' . $comment->id, ['text' => $newText])
            ->seeStatusCode(404);

        $this->put('posts/' . $post->id . '/comments/' . $comment->id, ['text' => $newText])
            ->seeStatusCode(200);

        $this->put('posts/' . $post->id . '/comments/' . ($comment->id + 2), ['text' => $newText])
            ->seeStatusCode(404);

        $this->seeInDatabase('comments', ['id' => $comment->id, 'text' => $newText]);

        $user2 = User::factory()->create();
        $comment2 = Comment::factory()->create([
            'user_id' => $user2->id,
            'post_id' => $post->id,
        ]);
        $this->put('posts/' . $post->id . '/comments/' . $comment2->id, ['text' => $newText])
            ->seeStatusCode(401);
    }

    public function testCommentDelete()
    {
        $user = User::factory()->create();
        $user2 = User::factory()->create();
        $post = Post::factory()->create([
            'user_id' => $user->id,
        ]);
        $comment = Comment::factory()->create([
            'user_id' => $user->id,
            'post_id' => $post->id,
        ]);
        $comment2 = Comment::factory()->create([
            'user_id' => $user2->id,
            'post_id' => $post->id,
        ]);

        $this->delete('posts/' . $post->id . '/comments/' . $comment->id)
            ->seeStatusCode(401);
        $this->seeInDatabase('comments', ['id' => $comment->id]);

        $this->actingAs($user);
        $this->delete('posts/' . ($post->id + 1) . '/comments/' . $comment->id)
            ->seeStatusCode(404);

        $this->delete('posts/' . $post->id . '/comments/' . $comment->id)
            ->seeStatusCode(200);
        $this->notSeeInDatabase('comments', ['id' => $comment->id]);

        $this->delete('posts/' . $post->id . '/comments/' . 1)
            ->seeStatusCode(404);

        $this->delete('posts/' . $post->id . '/comments/' . $comment2->id)
            ->seeStatusCode(401);
    }

    public function testCommentNew()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create([
            'user_id' => $user->id,
        ]);
        $sampleText = Str::random(300);

        $this->post('posts/' . $post->id . '/comments', ['text' => $sampleText])
            ->seeStatusCode(401);
        $this->notSeeInDatabase('comments', ['user_id' => $user->id, 'post_id' => $post->id, 'text' => $sampleText]);

        $this->actingAs($user);
        $this->post('posts/' . ($post->id + 1) . '/comments', ['text' => $sampleText])
            ->seeStatusCode(404);

        $this->post('posts/' . $post->id . '/comments', ['text' => $sampleText])
            ->seeStatusCode(200);
        $this->seeInDatabase('comments', ['user_id' => $user->id, 'post_id' => $post->id, 'text' => $sampleText]);
    }

    public function testCommentCoverage()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $post = Post::factory()->create([
            'user_id' => $user->id,
        ]);
        $comment = Comment::factory()->create([
            'post_id' => $post->id,
            'user_id' => $user->id,
        ]);
        $post = Post::find($post->id);

        $this->assertEquals([$user->toArray()], $comment->user()->get()->toArray());
        $this->assertEquals([$post->toArray()], $comment->post()->get()->toArray());
    }

    public function testCommentNewValidation()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $post = Post::factory()->create([
            'user_id' => $user->id,
        ]);

        $this->post('posts/' . $post->id . '/comments', [])
            ->seeStatusCode(422);
        $this->notSeeInDatabase('comments', ['user_id' => $user->id, 'post_id' => $post->id]);

        $this->post('posts/' . $post->id . '/comments', ['text' => 'txt'])
            ->seeStatusCode(200);
        $this->seeInDatabase('comments', ['user_id' => $user->id, 'text' => 'txt', 'post_id' => $post->id]);
    }
}
