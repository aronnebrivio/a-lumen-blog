<?php

namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function getAll(Request $request)
    {
        $post_id = $request->all()['post_id'];
        return Comment::where("post_id", $post_id)->get();
    }

    public function new(Request $request)
    {
        /* insert */
        $comment = new Comment;
        $comment->fill($request->all());
        $comment->save();
    }

    public function update(Request $request, $id)
    {
        $comment = Comment::find($id);
        /* update */
        $comment->fill($request->all());
        $comment->save();

        return $comment;
    }
}
