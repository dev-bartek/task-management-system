<?php

use Illuminate\Support\Facades\Route;

Route::redirect('/', '/tasks');

Route::group(['middleware' => 'auth'], function () {
    Route::view('tasks', 'tasks')
        ->name('tasks');

    Route::view('profile', 'profile')
        ->name('profile');
});

require __DIR__.'/auth.php';
