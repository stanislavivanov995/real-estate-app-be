<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoriesController;
use Illuminate\Support\Facades\Route;

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('user', [AuthController::class, 'user']);
    Route::post('logout', [AuthController::class, 'logout']);
});

Route::get('/list-categories', [CategoriesController::class, 'getCategories']);
