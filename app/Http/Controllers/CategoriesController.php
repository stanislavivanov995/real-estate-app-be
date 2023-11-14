<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\JsonResponse;


class CategoriesController extends Controller
{
    public function getCategories(): JsonResponse
    {
        $list = Category::all();

        return response()->json($list);
    }
}
