<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Post;
use App\Scopes\AuthScope;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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

    public function update(Request $request, $id)
    {
        $comment = Comment::find($id);

        if (!Gate::allows('update', $comment)) {
            throw new ModelNotFoundException();
        }

        $comment->fill($request->all());
        $comment->save();

        return $this->getOne($comment->id);
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
        $comment = Comment::find($id);

        if (!Gate::allows('delete', $comment)) {
            throw new ModelNotFoundException();
        }

        $comment->delete();

        return [];
    }

    private function getOne($id)
    {
        return Comment::findOrFail($id);
    }
}
