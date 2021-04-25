<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    /**
     * @var array
     */
    protected $fillable = [
        'text',
        'title',
    ];

    /**
     * @var array
     */
    protected $guarded = [
        'id',
    ];

    /**
     * @var array
     */
    protected $hidden = [
        'user_id',
    ];

    /**
     * @var string
     */
    protected $table = 'posts';

    /**
     * @var array
     */
    protected $with = [
        'user',
    ];

    /**
     * @var array
     */
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
