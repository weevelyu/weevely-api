<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calendar extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'main',
        'hidden',
        'shared'
    ];

    protected $casts = [
        'user_id' => 'integer',
        'title' => 'string',
        'main' => 'boolean',
        'hidden' => 'boolean',
        'shared' => 'boolean'
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }
}
