<?php

namespace App\Http\Controllers;

use App\Models\Estate;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\StoreEstateRequest;
use Illuminate\Support\Facades\Http;


class EstatesController extends Controller
{
    protected function fetchRates()
    {
        $currencyRatesAPI = 'https://cdn.moneyconvert.net/api/latest.json';

        $response = Http::get($currencyRatesAPI);

        $currencyRates = json_decode($response, true);

        $currencyRates = $currencyRates['rates'];

        $baseCurrency = $currencyRates['BGN'];

        $result = array();

        foreach ($currencyRates as $currency=>$rate) {
            if (in_array($currency, ['USD', 'EUR', 'BGN'])) {
            $result[$currency] = $rate/$baseCurrency;}
        }

        return $result;
    }


    public function list(): ?JsonResponse
    {
        $exchangeData = $this->fetchRates();

        $list = Estate::all();
        
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
