<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CommentPolicy
{
    private string $unauthorizedMessage = 'You do not own this comment';

    /**
     * Determine if the given comment can be updated by the user.
     *
     * @param User    $user
     * @param Comment $comment
     *
     * @return Response
     */
    public function update(User $user, Comment $comment): Response
    {
        return $user->id === $comment->user_id
            ? Response::allow()
            : Response::deny($this->unauthorizedMessage);
    }

    /**
     * Determine if the given comment can be deleted by the user.
     *
     * @param User    $user
     * @param Comment $comment
     *
     * @return Response
     */
    public function delete(User $user, Comment $comment): Response
    {
        return $user->id === $comment->user_id
            ? Response::allow()
            : Response::deny($this->unauthorizedMessage);
    }
}
