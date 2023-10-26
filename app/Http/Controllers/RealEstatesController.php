<?php

namespace App\Http\Controllers;

use App\Models\Image;
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

    public function store(StoreEstateRequest $request, Image $image): JsonResponse
    {
        $data = $request->json()->all();

        $realEstate = RealEstate::create($data);

        if (count($request->files) > 0) {
            dd($request->files);

            foreach ($request->files as $file) {
                $file->store('images', 'public');
                $image = Image::create($file);
                $id = $image['id'];
                $realEstate['to_images'] = $id;
            }
        }

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
