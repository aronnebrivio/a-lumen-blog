<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Laravel\Lumen\Routing\Controller as BaseController;

class PostController extends BaseController
{
    /**
     * @param int|string $id
     *
     * @throws \Exception
     *
     * @return Post
     */
    public function get($id)
    {
        return $this->getOne($id);
    }

    public function getAll()
    {
        return Post::orderBy('created_at', 'desc')
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
        $post->user_id = Auth::user()->id;
        $post->save();

        return $this->getOne($post->id);
    }

    /**
     * @param Request    $request
     * @param int|string $id
     *
     * @throws \Exception
     *
     * @return Post
     */
    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        Gate::authorize('update', $post);

        $post->fill($request->all());
        $post->save();

        return $this->getOne($post->id);
    }

    /**
     * @param int|string $id
     *
     * @throws \Exception
     *
     * @return array
     *
     * @psalm-return array<empty, empty>
     */
    public function delete($id): array
    {
        $post = Post::findOrFail($id);

        Gate::authorize('delete', $post);

        $post->delete();

        return [];
    }

    /**
     * @param int|string $id
     *
     * @throws \Exception
     *
     * @return Post
     */
    private function getOne($id)
    {
        return Post::findOrFail($id);
    }
}
