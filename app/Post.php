<?php

namespace App;

use App\Scopes\AuthScope;
use App\Traits\AuthTrait;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use AuthTrait;

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
        return $this->hasMany(Comment::class, 'post_id')->withoutGlobalScope(AuthScope::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
