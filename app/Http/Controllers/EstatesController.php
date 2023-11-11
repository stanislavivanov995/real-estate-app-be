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
        $estate = Estate::create([
            'user_id' => $request->user_id,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'currency' => $request->currency,
            'latitude' => $request->latitude,
            'longtitude' => $request->longtitude,
            'category' => $request->category_id,
            'rooms' => $request->rooms,
            'arrive_hour' => $request->arrive_hour,
            'leave_hour' => $request->leave_hour
        ]);

        return response()->json(["success" => true, 'estate' => $estate]);
    }


    public function update(StoreEstateRequest $request, string $id): ?JsonResponse
    {
        $estate = Estate::findOrFail($id);

        $estate->update([
            'user_id' => $request->user_id,
            'name' => $request->name,
            'description' => $request->description,
            'rooms' => $request->rooms,
            'price' => $request->price,
            'currency' => $request->currency,
            'latitude' => $request->latitude,
            'longtitude' => $request->longtitude,
            'category_id' => $request->category_id,
            'arrive_hour' => $request->arrive_hour,
            'leave_hour' => $request->leave_hour
        ]);

        return response()->json(["success" => true, 'estate' => $estate]);
    }


    public function delete(string $id): ?JsonResponse
    {
        $estate = Estate::findOrFail($id);

        $estate->delete();

        return response()->json(["success" => true]);
    }
}
