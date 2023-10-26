<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Estate;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\StoreEstateRequest;


class RealEstatesController extends Controller
{

    public function list(): ?JsonResponse
    {
        $list = Estate::all();

        return response()->json(['Estates' => $list]);
    }

    public function show(string $id): JsonResponse
    {
        $estate = Estate::findOrFail($id);

        return response()->json(['Estate' => $estate]);
    }

    public function store(StoreEstateRequest $request, Image $image): JsonResponse
    {
        $data = $request->json()->all();

        $estate = Estate::create($data);

        if (count($request->files) > 0) {
            foreach ($request->files as $file) {
                $file->store('images', 'public');
                $image = Image::create([
                    'filename' => $file->originalName,
                    'path' => 'public/images/' . $file->originalName,
                    'size' => $file['size'],
                    'mime_type' => $file->mimeType,
                    'to_estate' => $estate['id'],
                ]);
            }
        }

        return response()->json(['Estate' => $estate, 'Image' => $image]);
    }

    public function update(StoreEstateRequest $request, string $id): JsonResponse
    {
        $estate = Estate::findOrFail($id);

        $data = $request->json()->all();

        $estate->update($data);

        return response()->json(['Estate' => $estate]);
    }

    public function delete(string $id): JsonResponse
    {
        $estate = Estate::findOrFail($id);

        $estate->delete();

        return response()->json(['message' => $estate['title'] . ' deleted']);
    }
}
