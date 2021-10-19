<?php

return [
    'paths' => ['api/*', 'fruitcake/laravel-cors'],
    'allowed_methods' => ['GET', 'POST', 'PATCH', 'DELETE', 'OPTIONS'],
    'allowed_origins' => ['*'],
    'allowed_origins_patterns' => [],
    'allowed_headers' => ['Origin', 'X-Requested-With', 'Authorization', 'Set-Cookie', 'Content-Type', 'Accept', 'x-custom-header'],
    'exposed_headers' => ['x-custom-response-header'],
    'max_age' => 60,
    'supports_credentials' => true
];
