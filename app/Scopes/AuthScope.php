<?php

namespace App\Scopes;

use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

class AuthScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        /** @var User $user */
        $user = Auth::user();
        $builder->where('user_id', $user->id);
    }
}