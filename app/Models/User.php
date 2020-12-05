<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'lastname', 'email', 'password', 'phone', 'address', 'is_active',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    /**
     * @return HasOne
     */
    public function cart(): HasOne
    {
        return $this->hasOne(Cart::class);
    }

    /**
     * @param $value
     */
    public function setNameAttribute($value): void
    {
        $this->attributes['name'] = strtolower($value);
        $this->attributes['name'] = rtrim($value);
        $this->attributes['name'] = ucwords($value);
    }

    /**
     * @param $value
     */
    public function setLastnameAttribute($value): void
    {
        $this->attributes['lastname'] = strtolower($value);
        $this->attributes['lastname'] = rtrim($value);
        $this->attributes['lastname'] = ucwords($value);
    }

    /**
     * @return HasMany
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * @param $value
     */
    public function setEmailAttribute($value): void
    {
        $this->attributes['email'] = strtolower($value);
    }

    /**
     * @return string
     */
    public function getFullNameAttribute(): string
    {
        return "{$this->name} {$this->lastname}";
    }

    /**
     * @param $query
     * @param $search
     * @return mixed
     */
    public function scopeSearch($query, $search)
    {
        if (empty($search)) {
            return null;
        }

        return $query
                ->where('name', 'like', '%' . $search . '%')
                ->orWhere('lastname', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%')
                ->orWhere('phone', 'like', '%' . $search . '%');
    }
}
