<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;

    protected $fillable = [
        'email',
    ];
    protected $hidden = [
        'password',
        'token',
        'created_at',
        'updated_at',
    ];
    protected $guarded = [
        'id',
    ];
    protected $table = 'users';

    /* relationships */
    public function posts()
    {
        return $this->hasMany('App\Post');
    }

    public function comments()
    {
        return $this->hasMany('App\Comment');
    }
}
