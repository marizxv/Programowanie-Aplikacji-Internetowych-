<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;

// public actions
Route::get('/login',  [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'doLogin'])->name('login.post');

// protected actions
Route::middleware('checklogin')->group(function () {
    Route::get('/',         [HomeController::class,  'index'])->name('home');
    Route::get('/nickname', [LoginController::class, 'chooseNickname'])->name('nickname.show');
    Route::post('/nickname', [LoginController::class, 'saveNickname'])->name('nickname.save');
    Route::post('/logout',   [LoginController::class, 'doLogout'])->name('logout');
});
