<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoanController;

Route::get('/', [LoanController::class, 'index']);
