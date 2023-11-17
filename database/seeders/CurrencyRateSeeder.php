<?php

namespace Database\Seeders;

use App\Models\CurrencyRate;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;


class CurrencyRateSeeder extends Seeder
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
            $result[$currency] = $rate / $baseCurrency;}
        }

        return $result;
    }
    
    public function run(): void
    {
        $rates = $this->fetchRates();

        $data = array();

        DB::table('currency_rates')->truncate();

        foreach ($rates as $currency => $rate) {
            $data['currency'] = $currency;
            $data['rate'] = $rate;
            CurrencyRate::create($data);
        }
    }
}
