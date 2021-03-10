<?php

namespace App\Policies;

use App\Post;
use App\User;
use Illuminate\Auth\Access\Response;

class PostPolicy
{
    private $unauthorizedMessage = 'You do not own this post';

    /**
     * Determine if the given post can be updated by the user.
     *
     * @param  User  $user
     * @param  Post  $post
     * @return bool
     */
    public function update(User $user, Post $post)
    {
        return $user->id === $post->user_id
            ? Response::allow()
            : Response::deny($this->unauthorizedMessage);
    }

    /**
     * Determine if the given post can be deleted by the user.
     *
     * @param  User  $user
     * @param  Post  $post
     * @return bool
     */
    public function delete(User $user, Post $post)
    {
        return $user->id === $post->user_id
            ? Response::allow()
            : Response::deny($this->unauthorizedMessage);
    }
}
