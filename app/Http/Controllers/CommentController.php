<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Post;
use App\Scopes\AuthScope;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function getAll(Request $request)
    {
        $post_id = $request->all()['post_id'];
        Post::withoutGlobalScope(AuthScope::class)->findOrFail($post_id);
        return Comment::withoutGlobalScope(AuthScope::class)->where('post_id', $post_id)->get();
    }

    public function new(Request $request)
    {
        $post_id = $request->all()['post_id'];
        Post::withoutGlobalScope(AuthScope::class)->findOrFail($post_id);
        $comment = new Comment;
        $comment->fill($request->all());
        $comment->save();
        return 1;
    }

    public function update(Request $request, $id)
    {
        $comment = Comment::where('id', $id)->first();
        $comment->fill($request->all());
        $comment->save();

        return $comment;
    }

    public function delete($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();
        return 1;
    }
}
