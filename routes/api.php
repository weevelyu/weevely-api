<?php

use Illuminate\Support\Facades\Route;

/**
 * Authorization module
 */
Route::prefix('auth')->group(function () {
    Route::post('/register', 'App\Http\Controllers\AuthController@Register');
    Route::post('/signin', 'App\Http\Controllers\AuthController@SignIn');
    Route::post('/signout', 'App\Http\Controllers\AuthController@SignOut')->middleware('auth');
    Route::get('/refresh', 'App\Http\Controllers\AuthController@refresh')->middleware('auth');
    Route::get('/me', 'App\Http\Controllers\AuthController@me')->middleware('auth');
    Route::post('/password-reset', 'App\Http\Controllers\PasswordResetsController@ForgotPassword');
    Route::post('/password-reset/{token}', 'App\Http\Controllers\PasswordResetsController@ResetPassword');
    Route::get('/password-reset/{token}/remove', 'App\Http\Controllers\PasswordResetsController@RemoveRequestPassword');
});


/**
 * User control module
 */
Route::prefix('users')->middleware('auth')->group(function () {
    Route::post('/avatar', 'App\Http\Controllers\UserController@uploadAvatar');
});
Route::apiResource('users', 'App\Http\Controllers\UserController');


/**
 * Calendar control module
 */
Route::prefix('calendars')->middleware('auth')->group(function () {
    Route::get('/my', 'App\Http\Controllers\CalendarController@showCalendars');
    Route::post('/my', 'App\Http\Controllers\CalendarController@createCalendar');
    Route::post('/{id}/events', 'App\Http\Controllers\CalendarController@calendarEvents');
    Route::post('/{id}/clear', 'App\Http\Controllers\CalendarController@clearCalendar');
});
Route::apiResource('calendars', 'App\Http\Controllers\CalendarController');


/**
 * Events control module
 */
Route::prefix('events')->group(function () {
});
Route::apiResource('events', 'App\Http\Controllers\EventController');
