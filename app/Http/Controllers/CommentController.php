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

        return Comment::withoutGlobalScope(AuthScope::class)
            ->where('post_id', $request->all()['post_id'])
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

        $postId = $request->all()['post_id'];
        Post::withoutGlobalScope(AuthScope::class)->findOrFail($postId);

        $comment = new Comment;
        $comment->fill($request->all());
        $comment->post_id = $postId;
        $comment->save();

        return $this->getOne($comment->id);
    }

    public function update(Request $request, $id)
    {
        /** @var Comment $comment */
        $comment = Comment::where('id', $id)->first();
        $comment->fill($request->all());
        $comment->save();

        return $this->getOne($comment->id);
    }

    /**
     * @param $id
     * @return array
     * @throws \Exception
     */
    public function delete($id)
    {
        /** @var Comment $comment */
        $comment = Comment::findOrFail($id);
        $comment->delete();
        return [];
    }

    private function getOne($id)
    {
        return Comment::withoutGlobalScope(AuthScope::class)
            ->findOrFail($id);
    }
}
