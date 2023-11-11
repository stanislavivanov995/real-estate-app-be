<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\EstatesController;
use Illuminate\Support\Facades\Route;

/*
API requests:
| '/' => 'index'
| '/real_estates' => 'All real_estates'
| '/real_estates/{id}' => 'real_estate with id'
| '/real_estates/create' => 'Create real estate'
| '/real_estates/edit/{id}' => 'Update real estate with id'
| '/real_estates/delete/{id}' => 'Delete real estate with id'
|
| 'register' => 'Register user'
| 'login' => 'Login user
|
| 'list-categories' => 'All categories'
*/


Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('user', [AuthController::class, 'user']);
    Route::post('logout', [AuthController::class, 'logout']);
});

Route::get('/list-categories', [CategoriesController::class, 'getCategories']);

Route::get('/real_estates', [EstatesController::class, 'list']);

Route::get('/real_estates/{id}', [EstatesController::class, 'show']);

Route::post('/real_estates/create', [EstatesController::class, 'store']);

Route::put('/real_estates/edit/{id}', [EstatesController::class, 'update']);

Route::delete('/real_estates/delete/{id}', [EstatesController::class, 'delete']);
