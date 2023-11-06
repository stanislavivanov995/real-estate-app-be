<?php

use App\Http\Controllers\CategoriesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/list-categories', [CategoriesController::class, 'getCategories']);
