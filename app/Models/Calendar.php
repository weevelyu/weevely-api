<?php

namespace App\Models;

class Calendar extends \Illuminate\Database\Eloquent\Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    protected $fillable = [
        'title',
        'main',
        'hidden',
        'shared'
    ];

    protected $casts = [
        'title' => 'string',
        'main' => 'boolean',
        'hidden' => 'boolean',
        'shared' => 'boolean'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot(['is_owner'])->as('calendar_user');
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }
}
