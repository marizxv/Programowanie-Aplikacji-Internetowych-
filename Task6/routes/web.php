<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\LoginController;

// public actions
Route::get('/login',  [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'doLogin'])->name('login.post');

// protected actions
Route::middleware('checklogin')->group(function () {
    Route::get('/',         [LoanController::class,  'index'])->name('home');
    Route::post('/compute', [LoanController::class,  'process'])->name('compute');
    Route::post('/logout',  [LoginController::class, 'doLogout'])->name('logout');
});
