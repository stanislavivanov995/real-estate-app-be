<?php

use App\Http\Controllers\RealEstatesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

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

Route::put('real_estates/edit/{id}', [RealEstatesController::class, 'update']);

Route::delete('real_estates/delete/{id}', [RealEstatesController::class, 'delete']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});