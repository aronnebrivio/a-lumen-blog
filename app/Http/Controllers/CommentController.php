<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Laravel\Lumen\Routing\Controller as BaseController;

class CommentController extends BaseController
{
    /**
     * @param Request $request
     *
     * @throws \Illuminate\Validation\ValidationException
     *
     * @return mixed
     */
    public function getAll(Request $request)
    {
        $this->validate($request, [
            'post_id' => 'required|integer|min:1',
        ]);

        return Comment::where('post_id', $request->all()['post_id'])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * @param Request $request
     *
     * @throws \Illuminate\Validation\ValidationException
     *
     * @return Comment
     */
    public function new(Request $request)
    {
        $this->validate($request, [
            'text' => 'required',
            'post_id' => 'required',
        ]);

        $postId = $request->all()['post_id'];
        Post::findOrFail($postId);

        $comment = new Comment();
        $comment->fill($request->all());
        $comment->user_id = Auth::user()->id;
        $comment->post_id = $postId;
        $comment->save();

        return $this->getOne($comment->id);
    }

    /**
     * @param Request $request
     * @param int|string $id
     *
     * @throws \Illuminate\Validation\ValidationException
     *
     * @return Comment
     */
    public function update(Request $request, $id)
    {
        $comment = Comment::findOrFail($id);

        Gate::authorize('update', $comment);

        $comment->fill($request->all());
        $comment->save();

        return $this->getOne($comment->id);
    }

    /**
     * @param int|string $id
     *
     * @throws \Exception
     *
     * @return array
     */
    public function delete($id)
    {
        $comment = Comment::findOrFail($id);

        Gate::authorize('delete', $comment);

        $comment->delete();

        return [];
    }

    /**
     * @param int|string $id
     *
     * @throws \Exception
     *
     * @return Comment
     */
    private function getOne($id)
    {
        return Comment::findOrFail($id);
    }
}
