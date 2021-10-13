<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Model implements AuthenticatableContract, AuthorizableContract, JWTSubject
{
    use Authenticatable;
    use Authorizable;
    use HasFactory;

    /**
     * @var array
     */
    protected $fillable = [
        'email',
        'first_name',
        'last_name',
        'picture',
    ];

    /**
     * @var array
     */
    protected $hidden = [
        'password',
        'updated_at',
    ];

    /**
     * @var array
     */
    protected $guarded = [
        'id',
        'created_at',
    ];

    /**
     * @var array
     */
    protected $appends = [
        'full_name',
    ];

    /**
     * @var string
     */
    protected $table = 'users';

    // mutators
    public function getFullNameAttribute(): string
    {
        if ($this->attributes['first_name'] && $this->attributes['last_name']) {
            return $this->attributes['first_name'] . ' ' . $this->attributes['last_name'];
        }

        return $this->attributes['email'];
    }

    // relationships
    public function posts(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Post::class, 'user_id', 'id');
    }

    public function comments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Comment::class, 'user_id', 'id');
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     *
     * @psalm-return array<empty, empty>
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
