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

    /* Test controller
    TODO: Delete it
    */
    public function getAllCategoryEstates()
    {
        return Category::find(3)->estates;
    }
}
