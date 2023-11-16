<?php

namespace App\Http\Controllers;

use App\Models\Estate;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\StoreEstateRequest;
use App\Models\CurrencyRate;


class EstatesController extends Controller
{
    protected function convertCurrency($estate, $currentCurrency)
    {
        // EURGBP = (BGNGBP / BGNEUR) = 
        $rates = array();
        $currencyRates = CurrencyRate::all()->toArray();

        foreach ($currencyRates as $data) {
            $rates[$data['currency']] = $data['rate'];
        }

        $estateExchRate = $rates[$currentCurrency] / $rates[$estate['currency']];

        $price = intval(round($estate['price'] * $estateExchRate));
        
        return $price;
    }


    public function list(): ?JsonResponse
    {
        $exchangeData = CurrencyRate::all();

        $list = Estate::all();
        
        $list->map(function ($estate) {
            /*
            TODO: handle hardcoded input - currency
            */
            return $estate['price'] = $this->convertCurrency($estate, 'BGN');
        });
        
        $softDeleted = Estate::onlyTrashed()->get();

        return response()->json(['estates' => $list, 'deleted' => $softDeleted, 'rates' => $exchangeData]);
    }


    public function show(string $id): ?JsonResponse
    {
        $estate = Estate::findOrFail($id);

        return response()->json(['estate' => $estate]);
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
}
