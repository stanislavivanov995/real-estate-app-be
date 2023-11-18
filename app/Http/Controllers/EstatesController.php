<?php

namespace App\Http\Controllers;

use App\Models\Estate;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\StoreEstateRequest;


class EstatesController extends Controller
{
    
    protected function filterEstates($category=null, $location=null)
    {
        if ($category) {
            $estatesList = Estate::where('category_id', $category)->get();
        } elseif ($location) {
            /* TODO: */
        } else {
            $estatesList = Estate::all();
        }

        return $estatesList;
    }


    public function list(Request $request): ?JsonResponse
    {
        $category = $request->input('category');

        $location = $request->input('location');

        $list = $this->filterEstates($category, $location);

        return response()->json($list);
    }


    public function show(string $id): ?JsonResponse
    {
        $estate = Estate::findOrFail($id);

        return response()->json(['estate' => $estate]);
    }
    

    public function store(StoreEstateRequest $request): ?JsonResponse
    {
        $estate = Estate::create($request->all());

        return response()->json(["success" => true, 'estate' => $estate]);
    }
    

    public function update(StoreEstateRequest $request, string $id): ?JsonResponse
    {
        $estate = Estate::findOrFail($id);

        $estate->update($request->all());

        return response()->json(["success" => true, 'estate' => $estate]);
    }


    public function delete(string $id): ?JsonResponse
    {
        $estate = Estate::findOrFail($id);

        $estate->delete();

        return response()->json(["success" => true]);
    }
}
