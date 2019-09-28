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
        'first_name',
        'last_name',
    ];

    protected $hidden = [
        'password',
        'token',
        'updated_at',
    ];

    protected $guarded = [
        'id',
        'created_at',
    ];

    protected $appends = [
        'full_name',
    ];

    protected $table = 'users';

    /* mutators */
    public function getFullNameAttribute()
    {
        if ($this->attributes['first_name'] && $this->attributes['last_name'])
            return $this->attributes['first_name'] . ' ' . $this->attributes['last_name'];
        return $this->attributes['email'];
    }

    /* relationships */
    public function posts()
    {
        return $this->hasMany(Post::class, 'user_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'user_id', 'id');
    }
}
