<?php

namespace App\Exceptions;

class Handler extends \Illuminate\Foundation\Exceptions\Handler
{
    protected $dontReport = [];

    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function register()
    {
    }
}
