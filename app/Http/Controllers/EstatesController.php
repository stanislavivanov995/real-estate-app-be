<?php

namespace App\Http\Controllers;

use App\Models\Estate;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\StoreEstateRequest;


class EstatesController extends Controller
{

    protected function calcEstateDistance()
    {
        // TODO:
    }

    protected function filterEstates($request)
    {
        switch ($request)
        {
            case $request->filled('category'):
                $estatesList = Estate::where('category_id', $request->input(['category']))->get();
                break;

            case $request->has(['latitude', 'longitude', 'perimeter']):
                dd($request->input('latitude'), $request->input('longitude'), $request->input('perimeter'));

            default:
                $estatesList = Estate::all();
        }

        return $estatesList;
    }


    public function list(Request $request): ?JsonResponse
    {
        $list = $this->filterEstates($request);

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
