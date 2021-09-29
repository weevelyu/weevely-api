<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
    }

    public function boot()
    {
        \App\Http\Resources\PostsResource::withoutWrapping();
        \App\Http\Resources\LikeResource::withoutWrapping();
        \App\Http\Resources\CategoriesResource::withoutWrapping();
    }
}
