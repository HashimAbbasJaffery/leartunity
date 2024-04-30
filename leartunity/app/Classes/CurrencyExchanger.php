<?php 

namespace App\Classes;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;


class CurrencyExchanger {
    public function rate($ratesOf = "EUR") {
        $endpoint = "https://api.freecurrencyapi.com/v1/latest?apikey=" . env("CONVERTER_API_KEY") . "&currencies=" . $ratesOf . "&base_currency=USD";
        if(cache()->has($ratesOf)) {
            return cache()->get($ratesOf);
        } else {
            $result = Http::get($endpoint)->json("data.$ratesOf");
            cache()->put($ratesOf, $result, 60);
            return cache()->get($ratesOf);
        }
    }
}