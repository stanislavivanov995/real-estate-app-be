<?php

namespace App\Http\Controllers;

use App\Models\Category;
// use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function getCategories()
    {
        $list = Category::all();

        return response()->json($list);
    }
}
