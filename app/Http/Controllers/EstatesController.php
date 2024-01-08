<?php

namespace App\Http\Controllers;

use App\Http\Filters\EstatesFilter;
use App\Models\Image;
use App\Models\Estate;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\StoreImageRequest;
use App\Http\Requests\StoreEstateRequest;
use App\Utils\CalculateDistance;
use Illuminate\Support\Facades\Artisan;


class EstatesController extends Controller
{
    use CalculateDistance;

    private $imagesURL;
    

    function __construct()
    {
        $this->imagesURL = '/images/';
    }


    protected function filterByLocation($request, $estates)
    {      
        if ($request->filled('latitude') && $request->filled('longitude')) {

            $estates = collect($estates->filter(
                function ($estate) use ($request) {
                $radius = $request->query('radius', 0);

                return $this->distance($estate, $request) <= $radius;
            }));
        }

        return $estates;
    }


    public function list(EstatesFilter $filter, Request $request): ?JsonResponse
    {

        $list = Estate::filter($filter)->get();

        $filteredByLocation = $this->filterByLocation($request, $list);

        return response()->json(['estates' => $filteredByLocation]);
    }


    public function show(string $id): ?JsonResponse
    {
        $estate = Estate::findOrFail($id);

        return response()->json(['estate' => $estate, 'images' =>$estate->images]);
    }
    

    public function store(StoreEstateRequest $request, StoreImageRequest $imgRequest): ?JsonResponse
    {
        $estate = Estate::create($request->except('images'));

        $imageRequest = $request->files->get('images');

        foreach ($imageRequest as $image) {

            $imageName = time() . '_' . $image->getClientOriginalName();

            $imageLocation = public_path('images');

            $image->move($imageLocation, $imageName);
            
            $imgUrl = asset($this->imagesURL . $imageName);

            Image::create([
                'url' => $imgUrl,
                'path' => $imageLocation . '/' . $imageName,
                'estate_id' => $estate->id
            ]);
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

    
    public function getEstateReservations(string $id): JsonResponse
    {
        $reservations = collect(Estate::find($id)?->users);

        return response()->json($reservations);
    }


    public function emptyTrash(): JsonResponse
    {
        Artisan::call('model:prune');

        return response()->json('Confirmed');
    }
}
