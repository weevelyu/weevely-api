<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\EventController;

Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/signin', [AuthController::class, 'signIn']);
    Route::post('/signout', [AuthController::class, 'signOut'])->middleware('auth');
    Route::get('/refresh', [AuthController::class, 'refreshToken'])->middleware('auth');
    Route::get('/me', [AuthController::class, 'me'])->middleware('auth');
    Route::post('/reset-password', [PasswordResetController::class, 'ForgotPassword']);
    Route::post('/reset-password/{token}', [PasswordResetController::class, 'ResetPassword']);
    Route::get('/reset-password/{token}/remove', [PasswordResetController::class, 'RemoveRequestPassword']);
});

Route::prefix('users')->middleware('auth')->group(function () {
    Route::patch('/me', [UserController::class, 'updateMe']);
    Route::post('/me/avatar', [UserController::class, 'uploadAvatar']);
});
Route::apiResource('users', UserController::class);

Route::prefix('calendars')->middleware('auth')->group(function () {
    Route::post('/my', [CalendarController::class, 'createCalendar']);
    Route::get('/my/{type}', [CalendarController::class, 'showCalendars']);
    Route::post('/{id}/share', [CalendarController::class, 'shareCalendar']);
    Route::post('/{id}/hide', [CalendarController::class, 'hideCalendar']);
    Route::get('/{id}/events', [EventController::class, 'getCalendarEvents']);
    Route::post('/{calendar_id}/events', [EventController::class, 'createCalendarEvent']);
    Route::patch('/{calendar_id}/events/{event_id}', [EventController::class, 'updateCalendarEvent']);
    Route::delete('/{calendar_id}/events/{event_id}', [EventController::class, 'deleteCalendarEvent']);
    Route::post('/{id}/holidays', [EventController::class, 'parseHolidays']);
});
Route::apiResource('calendars', CalendarController::class);
Route::apiResource('events', EventController::class);
