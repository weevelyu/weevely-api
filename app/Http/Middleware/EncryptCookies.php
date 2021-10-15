<?php

namespace App\Http\Middleware;

class EncryptCookies extends \Illuminate\Cookie\Middleware\EncryptCookies
{
    protected $except = [
        'user',
    ];
}
