<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function get($id)
    {
        return Post::find($id);
    }

    public function getAll()
    {
        //return response()->json(Post::all(), 400);
        return Post::all();
    }

    public function new(Request $request)
    {
        /* insert */
        $post = new Post;
        $post->fill($request->all());
        $post->user_id = $request['user_id'];
        $post->save();
    }

    public function update(Request $request, $id)
    {
        $post = Post::find($id);
        /* update */
        $post->fill($request->all());
        $post->save();

        return $post;
    }
}
