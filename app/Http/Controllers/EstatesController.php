<?php

namespace App\Http\Controllers;

use App\Models\Estate;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\StoreEstateRequest;


class EstatesController extends Controller
{
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

        return response()->json(['estate' => $estate]);
    }

    //GET My Estates
    public function getMyEstates(Request $request): JsonResponse
    {
        try {
            // Validate the request parameters
            $request->validate([
                'user' => 'required|integer',
            ]);

            // Extract parameters from the request
            $userId = $request->input('user');

            // Retrieve estates from the database based on user ID in a paginated way
            $estates = Estate::where('user_id', $userId)
                ->get(['id','name','price','currency','latitude','longitude','category_id']);

            // Return the paginated estates in the desired JSON format
            return response()->json($estates);

        } catch (\Exception $exception) {
            // Handle exceptions and return an error response
            return response()->json([
                'message' => 'An error occurred, please try again!',
                'error' => $exception->getMessage()
            ], 500);
        }
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
