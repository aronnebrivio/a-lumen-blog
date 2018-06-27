<?php

namespace App\Http\Controllers;

use App\Post;
use App\Scopes\AuthScope;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;

class PostController extends BaseController
{
    public function get(Request $request, $id)
    {
        $post = Post::withoutGlobalScope(AuthScope::class)->findOrFail($id);
        if ($request->input('comments')) {
            $comments = Post::withoutGlobalScope(AuthScope::class)->findOrFail($id)->comments()->withoutGlobalScope(AuthScope::class)->get();
            $post->comments = $comments;
        }
        return $post;
    }

    public function getAll()
    {
        return Post::withoutGlobalScope(AuthScope::class)->get();
    }

    /**
     * @param Request $request
     * @return Post
     * @throws \Illuminate\Validation\ValidationException
     */
    public function new(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'text' => 'required'
        ]);
        $post = new Post;
        $post->fill($request->all());
        $post->save();

        return $post;
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
        return [];
    }

}
