<?php

use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/', function () {
    return view('landing');
});

Route::resource('users', UsersController::class);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
