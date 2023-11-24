<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Estate;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\StoreImageRequest;
use App\Http\Requests\StoreEstateRequest;


class EstatesController extends Controller
{
    private function uploadImages($imageRequest, $imgId): void
    {
        foreach ($imageRequest as $image) {

            $imageName = time() . '_' . $image->getClientOriginalName();

            $imageLocation = public_path('images');

            $image->move($imageLocation, $imageName);

            Image::create([
                'path' => $imageLocation . '/' . $imageName,
                'estate_id' => $imgId
            ]);
        }
    }


    protected function distance($estate, $request)
    {
        $earthRadius = 6371;
        
        $lat1 = $request->latitude;
        $lon1 = $request->longitude;
        $lat2 = $estate->latitude;
        $lon2 = $estate->longitude;

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon / 2) * sin($dLon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        $distance = $earthRadius * $c;

        return $distance;
    }


    protected function filterEstates($request)
    {
        $estates = collect(Estate::all());

        if ($request->filled('latitude') && $request->filled('longitude')) {
            $estates = collect($estates->filter(
                function ($estate) use ($request) {
                $radius = $request->query('radius', 0);
                return $this->distance($estate, $request) <= $radius;
            }));
        }

        if ($request->filled('category')) {
            $estates = $estates->where('category_id', $request->input('category'));
        }

        return $estates;
    }


    public function list(Request $request): ?JsonResponse
    {
        $list = $this->filterEstates($request);

        return response()->json($list);
    }


    public function show(string $id): ?JsonResponse
    {
        $estate = Estate::findOrFail($id);

        return response()->json(['estate' => $estate, 'images' =>$estate->images]);
    }


    public function store(StoreEstateRequest $request, StoreImageRequest $imgRequest): ?JsonResponse
    {
        $estate = Estate::create($request->except('image'));

        $imageRequest = $imgRequest->file('images');

        if ($imageRequest) {
            $this->uploadImages($imageRequest, $estate->id);
        }

        return response()->json(["success" => true, 'estate' => $estate, 'images' =>$estate->images]);
    }


    public function update(StoreEstateRequest $request,StoreImageRequest $imgRequest, string $id): ?JsonResponse
    {
        $estate = Estate::findOrFail($id);

        $estate->update($request->except('images'));

        $imageRequest = $imgRequest->file('images');

        if ($imageRequest) {
            $this->uploadImages($imageRequest, $estate->id);
        }

        return response()->json(["success" => true, 'estate' => $estate, 'images' =>$estate->images]);
    }


    public function delete(string $id): ?JsonResponse
    {
        $estate = Estate::findOrFail($id);

        $estate->delete();

        return response()->json(["success" => true]);
    }


    /*
    TODO: Delete controller?
    */
    public function getEstateReservations(string $id): JsonResponse
    {
        try {
            $reservations = Estate::find($id)->users;
        } catch (\Exception $e) {
            $reservations = [];
        }

        return response()->json($reservations);
    }
}
