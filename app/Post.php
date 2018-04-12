<?php

namespace App;

use App\Traits\AuthTrait;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use AuthTrait;

    /* attributes */
    protected $fillable = [
        'text',
        'title',
    ];
    protected $guarded = [
        'id',
        'user_id',
    ];
    protected $table = 'posts';

    /* relationships */
    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
