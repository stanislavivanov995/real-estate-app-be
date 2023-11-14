<?php

namespace App\Http\Controllers;

use App\Models\Estate;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\StoreEstateRequest;


class EstatesController extends Controller
{

    public function list(): ?JsonResponse
    {
        $list = Estate::all();
        
        $softDeleted = Estate::onlyTrashed()->get();

        return response()->json(['estates' => $list, 'deleted' => $softDeleted]);
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
