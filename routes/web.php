<?php

use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/', function () {
    return redirect('register');
});



Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
