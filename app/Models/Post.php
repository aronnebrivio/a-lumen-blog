<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

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

    // relationships
    public function comments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Comment::class, 'post_id');
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
