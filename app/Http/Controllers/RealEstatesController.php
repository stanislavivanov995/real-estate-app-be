<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Estate;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\StoreEstateRequest;
use Illuminate\Support\Facades\File;


class RealEstatesController extends Controller
{

    public function list(): ?JsonResponse
    {
        $list = Estate::all();
        $softDeleted = Estate::onlyTrashed()->get();

        return response()->json(['Estates' => $list, 'Deleted' => $softDeleted]);
    }


    public function show(string $id): ?JsonResponse
    {
        $estate = Estate::findOrFail($id);

        return response()->json(['Estate' => $estate]);
    }


    public function store(StoreEstateRequest $request): ?JsonResponse
    {
        $estate = Estate::create([
            'user_id' => $request->user_id,
            'name' => $request->name,
            'description' => $request->description,
            'rooms' => $request->rooms,
            'price' => $request->price,
            'currency' => $request->currency,
            'latitude' => $request->latitude,
            'longtitude' => $request->longtitude,
            'category' => $request->category,
            'arrive_hour' => $request->arrive_hour,
            'leave_hour' => $request->leave_hour,
        ]);

        // $this->addImage($request, $estate);

        return response()->json(["success" => true, 'Estate' => $estate]);
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
            'category' => $request->category,
            'arrive_hour' => $request->arrive_hour,
            'leave_hour' => $request->leave_hour,
        ]);;

        // $this->updateImage($request, $estate);

        return response()->json(['Estate' => $estate]);
    }


    public function delete(string $id, Image $image): ?JsonResponse
    {
        $estate = Estate::findOrFail($id);

        // $this->clearImages($estate);

        $estate->delete();

        return response()->json(['message' => $estate['name'] . ' deleted']);
    }


    protected function addImage($request, $estate)
    {
        if (count($request->files) > 0) {
            foreach ($request->files->all() as $imageFile) {

                $imageName = time() . '-' . $imageFile->getClientOriginalName();

                $imagePath = $imageFile->move(public_path('images'), $imageName);

                $isThumb = explode(".", 'is_thumbnail_' . $imageFile->getClientOriginalName())[0];

                Image::create([
                    'filename' => $imageName,
                    'path' => $imagePath,
                    'is_thumbnail' => $request->$isThumb,
                    'estate_id' => $estate->id,
                ]);
            }
        }
    }


    protected function updateImage($request, $estate)
    {
        if (count($request->files) > 0) {
            foreach ($request->files->all() as $imageFile) {

                $imageName = time() . '-' . $imageFile->getClientOriginalName();

                $imagePath = $imageFile->move(public_path('images'), $imageName);

                $isThumb = explode(".", 'is_thumbnail_' . $imageFile->getClientOriginalName())[0];

                Image::put([
                    'filename' => $imageName,
                    'path' => $imagePath,
                    'is_thumbnail' => $request->$isThumb,
                    'estate_id' => $estate->id,
                ]);
            }
        }
    }


    protected function clearImages($estate)
    {
        $estateImages = $estate->get_related_images($estate->id);

        foreach ($estateImages as $obj) {
            $img = public_path('images') . '/' . $obj['filename'];

            if (File::exists($img)) {
                File::delete($img);
            }
        }
    }
}
