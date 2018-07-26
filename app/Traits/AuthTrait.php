<?php

namespace App\Traits;

use App\Scopes\AuthScope;
use App\User;
use Illuminate\Support\Facades\Auth;

trait AuthTrait
{
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new AuthScope);
    }

    public function save(array $options = [])
    {
        /** @var User $user */
        $user = Auth::user();
        if ($user)
            $this->user_id = $user->id;
        parent::save($options);
    }
}