<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\JsonResponse;

// use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function getCategories(): JsonResponse
    {
        $list = Category::all();

        return response()->json($list);
    }
}
