<?php

use App\Http\Controllers\AuthController;
<<<<<<< HEAD
use App\Http\Controllers\RealEstatesController;
use Illuminate\Http\Request;
=======
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\EstatesController;
>>>>>>> main
use Illuminate\Support\Facades\Route;

/*
TODO: add documentation to readme.md
|
API requests:
|
| ESTATES:
| 'api/' => 'index'
| 'api/real-estates' => 'List all real estates'
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

<<<<<<< HEAD
/*
API requests:
| '/' => 'index',
| '/real_estates' => 'All real_estates',
| '/real_estates/{id}' => 'real_estate with id',
| '/real_estates/create' => 'Create real estate',
| '/real_estates/edit/{id}' => 'Update real estate with id',
| '/real_estates/delete/{id}' => 'Delete real estate with id',
*/

Route::get('/real_estates', [RealEstatesController::class, 'list']);

Route::get('/real_estates/{id}', [RealEstatesController::class, 'show']);

Route::post('/real_estates/create', [RealEstatesController::class, 'store']);

Route::put('/real_estates/edit/{id}', [RealEstatesController::class, 'update']);

Route::delete('/real_estates/delete/{id}', [RealEstatesController::class, 'delete']);


Route::post('/register', [AuthController::class, 'register']);

Route::post('/login', [AuthController::class, 'login']);

Route::get('/user', [AuthController::class, 'user']);

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
=======

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('user', [AuthController::class, 'user']);
    Route::post('logout', [AuthController::class, 'logout']);
});

Route::get('/list-categories', [CategoriesController::class, 'getCategories']);

Route::controller(EstatesController::class)->prefix('real-estates')->group(function () {
    Route::get('/', 'list');
    Route::get('/{id}', 'show');
    Route::post('/create', 'store');
    Route::put('/edit/{id}', 'update');
    Route::delete('/delete/{id}', 'delete');
});
>>>>>>> main
