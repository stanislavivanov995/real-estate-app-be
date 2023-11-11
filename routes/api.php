<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\EstatesController;
use Illuminate\Support\Facades\Route;

/*
API requests:
|
| ESTATES:
| '/' => 'index'
| '/real_estates' => 'All real_estates'
| '/real_estates/{id}' => 'real_estate with id'
| '/real_estates/create' => 'Create real estate'
| '/real_estates/edit/{id}' => 'Update real estate with id'
| '/real_estates/delete/{id}' => 'Delete real estate with id'
|
| USER:
| 'register' => 'Register user'
| 'login' => 'Login user
|
| CATEGORIES
| 'list-categories' => 'All categories'
*/


Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('user', [AuthController::class, 'user']);
    Route::post('logout', [AuthController::class, 'logout']);
});

Route::get('/list-categories', [CategoriesController::class, 'getCategories']);

Route::controller(EstatesController::class)->prefix('real_estates')->group(function () {
    Route::get('/', 'list');
    Route::get('/{id}', 'show');
    Route::post('/create', 'store');
    Route::put('/edit/{id}', 'update');
    Route::delete('/delete/{id}', 'delete');
});
