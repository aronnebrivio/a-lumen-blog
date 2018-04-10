<?php

class PostTest extends TestCase
{
    public function testGetPosts()
    {
        $user = factory(App\User::class)->create();
        $post = factory(App\Post::class)->create([
            'user_id' => $user->id
        ]);
        $this->get('/posts')
            ->seeStatusCode(200)
            ->seeJsonEquals([$post->toArray()]);
        $this->seeInDatabase('posts', $post->toArray());
    }

//    public function testC()
//    {
//        /* Creation test */
//        $this->user = factory(App\User::class)->create();
//        $this->post = factory(App\Post::class)->create([
//            'user_id' => 1
//        ]);
//        $this->comment = factory(App\Comment::class)->create([
//            'user_id' => 1,
//            'post_id' => 1
//        ]);
//
//        $user_controller = new UserController;
//        $post_controller = new PostController;
//        $comment_controller = new CommentController;
//
//        $tmpUser = $user_controller->get(1);
//        $tmpPost = $post_controller->get(1);
//        $tmpComment = $comment_controller->get(1);
//
//        try {
//            $this->assertTrue($this->user->email == $tmpUser->email);
//            $this->assertTrue($this->post->text == $tmpPost->text);
//            $this->assertTrue($this->comment->text == $tmpComment->text);
//        } catch (Exception $e) {
//            echo 'Caught exception: ',  $e->getMessage(), "\n";
//        }
//    }
//
//    public function test2()
//    {
//        $user_controller = new UserController;
//        $post_controller = new PostController;
//        $comment_controller = new CommentController;
//
//        $tmpUser = $user_controller->get(1);
//        $tmpPost = $post_controller->get(1);
//        $tmpComment = $comment_controller->get(1);
//
//        try {
//            $this->assertTrue($this->user->email == $tmpUser->email);
//            $this->assertTrue($this->post->text == $tmpPost->text);
//            $this->assertTrue($this->comment->text == $tmpComment->text);
//        } catch (Exception $e) {
//            echo 'Caught exception: ',  $e->getMessage(), "\n";
//        }
//    }
}
