<?php

namespace App\Models;

class User extends \Illuminate\Foundation\Auth\User implements \Tymon\JWTAuth\Contracts\JWTSubject
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory, \Illuminate\Notifications\Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'image',
        'shareId'
    ];

    protected $hidden = [
        'password'
    ];

    protected $casts = [
        'name' => 'string',
        'email' => 'string',
        'password' => 'string',
        'role' => 'string',
        'image' => 'string',
        'shareId' => 'string'
    ];

    public function calendars()
    {
        return $this->belongsToMany(Calendar::class)->withPivot(['is_owner'])->as('calendar_user');
    }

    public function owner()
    {
        return $this->belongsToMany(Calendar::class)->withPivot(['is_owner'])->wherePivot('is_owner', true)->as('calendar_user');
    }

    public function shared()
    {
        return $this->belongsToMany(Calendar::class)->withPivot(['is_owner'])->wherePivot('is_owner', false)->as('calendar_user');
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
