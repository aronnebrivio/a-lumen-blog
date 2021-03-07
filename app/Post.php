<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'text',
        'title',
    ];

    protected $guarded = [
        'id',
    ];

    protected $hidden = [
        'user_id',
    ];

    protected $table = 'posts';

    protected $with = [
        'user',
    ];

    protected $withCount = [
        'comments',
    ];

    /* relationships */
    public function comments()
    {
        return $this->hasMany(Comment::class, 'post_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
