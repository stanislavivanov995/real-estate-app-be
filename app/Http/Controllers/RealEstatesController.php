<?php

namespace App\Http\Controllers;

use App\Models\RealEstate;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\StoreEstateRequest;


class RealEstatesController extends Controller
{

    public function list(): ?JsonResponse
    {
        $list = RealEstate::all();

        return response()->json(['Valid' => $list]);
    }

    public function show(string $id): JsonResponse
    {
        $realEstate = RealEstate::findOrFail($id);

        return response()->json(['Valid' => $realEstate]);
    }

    public function store(StoreEstateRequest $request): JsonResponse
    {
        $data = $request->json()->all();

        $realEstate = RealEstate::create($data);

        return response()->json(['Valid' => $realEstate]);
    }

    public function update(StoreEstateRequest $request, string $id): JsonResponse
    {
        $realEstate = RealEstate::findOrFail($id);

        $data = $request->json()->all();

        $realEstate->update($data);

        return response()->json(['Valid' => $realEstate]);
    }

    public function delete(string $id): JsonResponse
    {
        $realEstate = RealEstate::findOrFail($id);

        $realEstate->delete();

        return response()->json(['message' => $realEstate['title'] . ' deleted']);
    }
}
