<?php

use App\Http\Controllers\CategoriesController;
use Illuminate\Support\Facades\Route;
// use Illuminate\Http\Request;


Route::get('/list-categories', [CategoriesController::class, 'getCategories']);
