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
     * @param Request    $request
     * @param int|string $postId
     *
     * @throws \Illuminate\Validation\ValidationException
     *
     * @return mixed
     */
    public function getAll(Request $request, $postId)
    {
        return Comment::where('post_id', $postId)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * @param Request    $request
     * @param int|string $postId
     *
     * @throws \Illuminate\Validation\ValidationException
     *
     * @return Comment
     */
    public function new(Request $request, $postId)
    {
        $this->validate($request, [
            'text' => 'required',
        ]);

        Post::findOrFail($postId);

        $comment = new Comment();
        $comment->fill($request->all());
        $comment->user_id = Auth::user()->id;
        $comment->post_id = $postId;
        $comment->save();

        return $this->getOne($comment->id);
    }

    /**
     * @param Request    $request
     * @param int|string $id
     * @param int|string $postId
     *
     * @throws \Illuminate\Validation\ValidationException
     *
     * @return Comment
     */
    public function update(Request $request, $postId, $id)
    {
        Post::findOrFail($postId);

        $comment = Comment::findOrFail($id);

        Gate::authorize('update', $comment);

        $comment->fill($request->all());
        $comment->save();

        return $this->getOne($comment->id);
    }

    /**
     * @param int|string $id
     * @param int|string $postId
     *
     * @throws \Exception
     *
     * @return array
     *
     * @psalm-return array<empty, empty>
     */
    public function delete($postId, $id)
    {
        Post::findOrFail($postId);

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
