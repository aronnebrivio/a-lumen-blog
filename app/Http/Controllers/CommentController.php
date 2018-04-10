<?php

namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function get($id)
    {
        return Comment::find($id);
    }

    public function getAll()
    {
        return Comment::all();
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
