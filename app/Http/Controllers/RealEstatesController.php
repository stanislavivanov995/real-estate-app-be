<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Estate;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\StoreImageRequest;
use App\Http\Requests\StoreEstateRequest;

class RealEstatesController extends Controller
{

    protected function addImage($request, $estate) {
        if (count($request->files) > 0) {
            foreach ($request->files->all() as $imageFile) {
                $imageName = time() . '-' . $imageFile->getClientOriginalName();

                $imagePath = $imageFile->move(public_path('images'), $imageName);

                $isThumb = explode(".", 'is_thumbnail_'.$imageFile->getClientOriginalName())[0];

                Image::create([
                    'filename' => $imageName,
                    'path' => $imagePath,
                    'is_thumbnail' => $request->$isThumb,
                    'estate_id' => $estate->id,
                ]);
            }
        }
    }

    protected function updateImage($request, $estate, $id) {
        if (count($request->files) > 0) {
            foreach ($request->files->all() as $imageFile) {
                $imageName = time() . '-' . $imageFile->getClientOriginalName();

                $imagePath = $imageFile->move(public_path('images'), $imageName);

                $isThumb = explode(".", 'is_thumbnail_'.$imageFile->getClientOriginalName())[0];

                Image::put([
                    'filename' => $imageName,
                    'path' => $imagePath,
                    'is_thumbnail' => $request->$isThumb,
                    'estate_id' => $estate->id,
                ]);
            }
        }
    }

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
        // $data = $request->all();
        // dd($data);
        $estate = Estate::create([
            'user_id' => $request->user_id,
            'title' => $request->title,
            'city' => $request->city,
            'address' => $request->address,
            'type' => $request->type,
            'rooms' => $request->rooms,
            'price' => $request->price,
        ]);

        $this->addImage($request, $estate);

        return response()->json(["success" => true, 'Estate' => $estate]);
    }


    public function imgUpload(Request $request)
    {
        
        if (count($request->files) > 0) {
            dd($request->files->all()['image1']);
            $img = $request->image;
            $imageName = time() . '-' . $img->filename . $img->guessExtension();
        }
    }


    public function update(StoreEstateRequest $request, string $id): JsonResponse
    {
        dd($request);
        $estate = Estate::findOrFail($id);

        $estate->update([
            'user_id' => $request->user_id,
            'title' => $request->title,
            'city' => $request->city,
            'address' => $request->address,
            'type' => $request->type,
            'rooms' => $request->rooms,
            'price' => $request->price,
        ]);;

        $this->updateImage($request, $estate, $image_ids);

        return response()->json(['Estate' => $estate]);
    }

    public function delete(string $id): JsonResponse
    {
        $estate = Estate::findOrFail($id);

        $estate->delete();

        return response()->json(['message' => $estate['title'] . ' deleted']);
    }
}
