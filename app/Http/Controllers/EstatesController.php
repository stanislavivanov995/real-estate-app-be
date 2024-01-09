<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Estate;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\StoreImageRequest;
use App\Http\Requests\StoreEstateRequest;
use App\Models\CurrencyRate;
use Illuminate\Support\Facades\Artisan;


class EstatesController extends Controller
{
    protected function convertCurrency($estate, $currentCurrency)
    {
        $rates = array();
        $currencyRates = CurrencyRate::all()->toArray();

        foreach ($currencyRates as $data) {
            $rates[$data['currency']] = $data['rate'];
        }

        $estateExchRate = $rates[$currentCurrency] / $rates[$estate['currency']];

        $price = intval(round($estate['price'] * $estateExchRate));

        return $price;
    }


    // public function list(): ?JsonResponse
    // {
    //     $exchangeData = CurrencyRate::all();

    //     $list = Estate::all();

    //     $list->map(function ($estate) {
    //         /*
    //         TODO: handle hardcoded input - currency
    //         */
    //         return $estate['price'] = $this->convertCurrency($estate, 'EUR');
    //     });
    // }



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
                }
            ));
        }

        if ($request->filled('category')) {
            $estates = $estates->where('category_id', $request->input('category'));
        }

        return $estates;
    }


    public function list(Request $request): ?JsonResponse
    {
        $list = $this->filterEstates($request);

        return response()->json(['estates' => $list]);
    }


    public function show(string $id): ?JsonResponse
    {
        $estate = Estate::findOrFail($id);

        return response()->json(['estate' => $estate, 'images' => $estate->images]);
    }


    public function store(StoreEstateRequest $request, StoreImageRequest $imgRequest): ?JsonResponse
    {
        $estate = Estate::create($request->except('image'));

        $imageRequest = $imgRequest->file('images');

        if ($imageRequest) {
            $this->uploadImages($imageRequest, $estate->id);
        }

        return response()->json(["success" => true, 'estate' => $estate, 'images' => $estate->images]);
    }


    public function update(StoreEstateRequest $request, StoreImageRequest $imgRequest, string $id): ?JsonResponse
    {
        $estate = Estate::findOrFail($id);

        $estate->update($request->except('images'));

        $imageRequest = $imgRequest->file('images');

        if ($imageRequest) {
            $this->uploadImages($imageRequest, $estate->id);
        }

        return response()->json(["success" => true, 'estate' => $estate, 'images' => $estate->images]);
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
