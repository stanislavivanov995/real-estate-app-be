<?php

namespace App\Http\Controllers;

use App\Models\Estate;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\StoreEstateRequest;

class EstatesController extends Controller
{
    protected function postRequestFileds($r) {
        define('fields', [
            'user_id' => $r->user_id,
            'name' => $r->name,
            'description' => $r->description,
            'price' => $r->price,
            'currency' => $r->currency,
            'latitude' => $r->latitude,
            'longtitude' => $r->longtitude,
            'category' => $r->category,
            'rooms' => $r->rooms,
            'arrive_hour' => $r->arrive_hour,
            'leave_hour' => $r->leave_hour
        ]);
        return fields;
    }


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
        $estate = Estate::create($this->postRequestFileds($request));

        return response()->json(["success" => true, 'estate' => $estate]);
    }
    

    public function update(StoreEstateRequest $request, string $id): ?JsonResponse
    {
        $estate = Estate::findOrFail($id);

        $estate->update($this->postRequestFileds($request));

        return response()->json(["success" => true, 'estate' => $estate]);
    }


    public function delete(string $id): ?JsonResponse
    {
        $estate = Estate::findOrFail($id);

        $estate->delete();

        return response()->json(["success" => true]);
    }
}
