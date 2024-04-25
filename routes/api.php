<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\UserController;

Route::post('/login', [UserController::class, 'login'])->name('users.login');
Route::post('/register', [UserController::class, 'store'])->name('users.store');

Route::apiResource('/todo', TodoController::class)->middleware('auth:sanctum');
