<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'text',
    ];

    protected $guarded = [
        'id',
    ];

    protected $hidden = [
        'user_id',
        'post_id',
    ];

    protected $table = 'comments';

    protected $with = [
        'user',
    ];

    // relationships
    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
