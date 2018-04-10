<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class Comment extends Model
{
    /* attributes */
    protected $fillable = [
        'text',
        'post_id',
    ];
    protected $guarded = [
        'id',
        'user_id',
        'created_at',
        'updated_at',
    ];
    protected $table = 'comments';

    /* relationships */
    public function post()
    {
        return $this->belongsTo('App\Post', 'post_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
