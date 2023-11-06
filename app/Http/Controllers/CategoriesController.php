<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function getCategories()
    {
        return response()->json([
            '1' => 'House',
            '2' => 'Apartments',
        ]);
    }
}
