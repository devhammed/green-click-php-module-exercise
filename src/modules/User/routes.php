<?php

use Illuminate\Support\Facades\Route;
use Modules\User\Http\Controllers\UserController;

Route::get('/users', [UserController::class, 'index'])
    ->name('users.index');

Route::post('/users/{user}/enable', [UserController::class, 'enable'])
    ->name('users.enable');

Route::post('/users/{user}/disable', [UserController::class, 'disable'])
    ->name('users.disable');
