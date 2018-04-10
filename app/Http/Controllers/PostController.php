<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function get($id)
    {
        $post = Post::find($id);
        if($post)
            return $post;

        return response('Post not found', 404);
    }

    public function getAll()
    {
        return Post::all();
    }

    public function new(Request $request)
    {
        $post = new Post;
        $post->fill($request->all());
        $post->user_id = $request['user_id'];
        $post->save();
    }

    public function update(Request $request, $id)
    {
        $post = Post::find($id);
        $post->fill($request->all());
        $post->save();

        return $post;
    }
}
