<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\EstatesController;
use Illuminate\Support\Facades\Route;

/*
TODO: add documentation to readme.md
|
API requests:
|
| ESTATES:
| 'api/' => 'index'
| 'api/real-estates' => 'List all real estates' (&latitude= &longitude= &radius= )
| 'api/real-estates/{id}' => 'Show single real estate'
| 'api/real-estates/create' => 'Create real estate'
| 'api/real-estates/edit/{id}' => 'Update real estate with id'
| 'api/real-estates/delete/{id}' => 'Delete real estate with id'
|
| USER:
| 'api/register' => 'Register user'
| 'api/login' => 'Login user
|
| CATEGORIES
| 'api/list-categories' => 'All categories'
*/


Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('user', [AuthController::class, 'user']);
    Route::post('logout', [AuthController::class, 'logout']);

    /* TODO: Delete test routes? ................................................ */
    Route::get('user/properties', [AuthController::class, 'getUserProperties']);
    Route::get('user/reservations', [AuthController::class, 'getUserReservations']);
    /* .......................................................................... */
});

Route::get('/list-categories', [CategoriesController::class, 'getCategories']);

Route::controller(EstatesController::class)->prefix('real-estates')->group(function () {
    Route::get('/', 'list');
    Route::get('/{id}', 'show');
    Route::post('/create', 'store');
    Route::put('/edit/{id}', 'update');
    Route::delete('/delete/{id}', 'delete');
});


/* TODO: Delete test route? */
Route::get('/real-estates/{id}/reservations', [EstatesController::class, 'getEstateReservations']);
