<?php

namespace App\Models;

class PasswordReset extends \Illuminate\Database\Eloquent\Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    protected $fillable = [
        'email',
        'token'
    ];

    protected $casts = [
        'email' => 'string',
        'token' => 'string'
    ];
}
