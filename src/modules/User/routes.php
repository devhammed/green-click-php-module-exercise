<?php

use Illuminate\Support\Facades\Route;
use Modules\User\Http\Controllers\UserController;

Route::get('/users', [UserController::class, 'index'])
    ->name('users.index');

Route::post('/users/enable/{user}', [UserController::class, 'enable'])
    ->name('users.enable');

Route::post('/users/disable/{user}', [UserController::class, 'disable'])
    ->name('users.disable');
