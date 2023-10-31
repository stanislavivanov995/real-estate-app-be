<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Estate;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\StoreImageRequest;
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
        // $data = $request->json()->all();
        $data = $request->all();

        $estate = Estate::create($data);
        
        // if (count($request->files) > 0) {
        //     foreach ($request->files as $file)

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $imageFile) {
                $imageName = time() . '-' . $imageFile->name . $imageFile->extension();
                dd($imageName);
                $imagePath = $imageFile->move(public_path('images'), $imageName);
                // $imagePath = $imageFile->store('images', 'public');

                Image::create([
                    'filename' => $imageFile->getClientOriginalName(),
                    'path' => $imagePath,
                    'size' => $imageFile->getSize(),
                    'mime_type' => $imageFile->getMimeType(),
                    'to_estate' => $estate->id,
                ]);
            }
        }

        // if ($request->hasFile('image')) {
        //     $imageName = time() . '-' . $request->filename . $request->extension();
        //     dd($imageName);
        // }

        return response()->json(["success" => true, 'Estate' => $estate, 'Image' => $image]);
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
