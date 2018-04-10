<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function getAll(Request $request)
    {
        $post_id = $request->all()['post_id'];
        $post = Post::find($post_id);
        if($post)
            return Comment::where('post_id', $post_id)->get();

        return response('Post not found', 404);
    }

    public function new(Request $request)
    {
        $comment = new Comment;
        $comment->fill($request->all());
        $comment->save();
    }

    public function update(Request $request, $id)
    {
        $comment = Comment::find($id);
        $comment->fill($request->all());
        $comment->save();

        return $comment;
    }
}