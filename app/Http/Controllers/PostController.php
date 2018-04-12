<?php

namespace App\Http\Controllers;

use App\Post;
use App\Scopes\AuthScope;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function get($id)
    {
        $post = Post::withoutGlobalScope(AuthScope::class)->findOrFail($id);
        return $post;
    }

    public function getAll()
    {
        return Post::withoutGlobalScope(AuthScope::class)->get();
    }

    public function new(Request $request)
    {
        $post = new Post;
        $post->fill($request->all());
        $post->save();
    }

    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);
        $post->fill($request->all());
        $post->save();

        return $post;
    }

    public function delete($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();
        return 1;
    }

}
