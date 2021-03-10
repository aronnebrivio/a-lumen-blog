<?php

namespace App\Policies;

use App\Comment;
use App\User;
use Illuminate\Auth\Access\Response;

class CommentPolicy
{
    private $unauthorizedMessage = 'You do not own this comment';

    /**
     * Determine if the given comment can be updated by the user.
     *
     * @param  User  $user
     * @param  Comment  $comment
     * @return bool
     */
    public function update(User $user, Comment $comment)
    {
        return $user->id === $comment->user_id
            ? Response::allow()
            : Response::deny($this->unauthorizedMessage);
    }

    /**
     * Determine if the given comment can be deleted by the user.
     *
     * @param  User  $user
     * @param  Comment  $comment
     * @return bool
     */
    public function delete(User $user, Comment $comment)
    {
        return $user->id === $comment->user_id
            ? Response::allow()
            : Response::deny($this->unauthorizedMessage);
    }
}
