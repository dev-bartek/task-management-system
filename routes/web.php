<?php

use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');

Route::view('tasks', 'tasks')
    ->middleware(['auth', 'verified'])
    ->name('tasks');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
