<?php

namespace App;

use App\Traits\AuthTrait;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use AuthTrait;

    protected $fillable = [
        'text',
        'post_id',
    ];
    protected $guarded = [
        'id',
        'user_id',
    ];
    protected $table = 'comments';

    /* relationships */
    public function post()
    {
        return $this->belongsTo('App\Post');
    }

    public function user()
    {
        return $this->hasOne('App\User');
    }
}
