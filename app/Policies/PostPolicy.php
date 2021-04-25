<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PostPolicy
{
    private string $unauthorizedMessage = 'You do not own this post';

    /**
     * Determine if the given post can be updated by the user.
     *
     * @param  User  $user
     * @param  Post  $post
     * @return Response
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
     * @return Response
     */
    public function delete(User $user, Post $post)
    {
        return $user->id === $post->user_id
            ? Response::allow()
            : Response::deny($this->unauthorizedMessage);
    }
}
