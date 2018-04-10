<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class Post extends Model
{
    /* attributes */
    protected $fillable = [
        'text',
    ];
    protected $guarded = [
        'id',
        'user_id',
    ];
    protected $table = 'posts';

    /* relationships */
    public function comments()
    {
        return $this->hasMany('App\Comment', 'post_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'post_id');
    }
}
