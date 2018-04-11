<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function get($id)
    {
        $post = Post::find($id);
        if ($post)
            return $post;

        return response('Post not found', 404);
    }

    public function getAll()
    {
        return Post::all();
    }

    public function new(Request $request)
    {
        $user = Auth::user();
        $post = new Post;
        $post->fill($request->all());
        $post->user_id = $user->id;
        $post->save();
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $post = Post::where('id', $id)
            ->where('user_id', $user->id)
            ->first();
        $post->fill($request->all());
        $post->save();

        return $post;
    }

    public function delete($id)
    {
        $user = Auth::user();
        $post = Post::where('id', $id)
            ->where('user_id', $user->id)
            ->first();
        if ($post) {
            $post->delete();
            return 1;
        }
        return response('Post not found', 404);
    }

}
