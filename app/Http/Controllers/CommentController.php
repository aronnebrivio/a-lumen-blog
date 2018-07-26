<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Post;
use App\Scopes\AuthScope;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;

class CommentController extends BaseController
{
    /**
     * @param Request $request
     * @return mixed
     * @throws \Illuminate\Validation\ValidationException
     */
    public function getAll(Request $request)
    {
        $this->validate($request, [
            'post_id' => 'required|integer|min:1',
        ]);
        $post_id = $request->all()['post_id'];
        Post::query()->withoutGlobalScope(AuthScope::class)->findOrFail($post_id);
        return Comment::query()->withoutGlobalScope(AuthScope::class)
            ->where('post_id', $post_id)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * @param Request $request
     * @return Comment
     * @throws \Illuminate\Validation\ValidationException
     */
    public function new(Request $request)
    {
        $this->validate($request, [
            'text' => 'required',
            'post_id' => 'required'
        ]);
        $post_id = $request->all()['post_id'];
        Post::query()->withoutGlobalScope(AuthScope::class)->findOrFail($post_id);
        $comment = new Comment;
        $comment->fill($request->all());
        $comment->save();
        return $comment;
    }

    public function update(Request $request, $id)
    {
        /** @var Comment $comment */
        $comment = Comment::query()->where('id', $id)->first();
        $comment->fill($request->all());
        $comment->save();

        return $comment;
    }

    /**
     * @param $id
     * @return array
     * @throws \Exception
     */
    public function delete($id)
    {
        /** @var Comment $comment */
        $comment = Comment::query()->findOrFail($id);
        $comment->delete();
        return [];
    }
}
