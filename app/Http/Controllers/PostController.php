<?php

namespace App\Http\Controllers;

use App\Post;
use App\Scopes\AuthScope;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;

class PostController extends BaseController
{
    public function get($id)
    {
        return $this->getOne($id);
    }

    public function getAll()
    {
        return Post::withoutGlobalScope(AuthScope::class)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * @param Request $request
     *
     * @throws \Illuminate\Validation\ValidationException
     *
     * @return Post
     */
    public function new(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'text' => 'required',
        ]);

        $post = new Post();
        $post->fill($request->all());
        $post->save();

        return $this->getOne($post->id);
    }

    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);
        $post->fill($request->all());
        $post->save();

        return $this->getOne($post->id);
    }

    /**
     * @param $id
     *
     * @throws \Exception
     *
     * @return array
     */
    public function delete($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return [];
    }

    private function getOne($id)
    {
        return Post::withoutGlobalScope(AuthScope::class)
            ->findOrFail($id);
    }
}
