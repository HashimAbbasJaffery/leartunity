<?php

namespace App\Helpers;
use Illuminate\Support\Facades\Http;

function google() {
    return 1;
}

function exchange_rate($ratesOf = "EUR") {
    $endpoint = "https://api.freecurrencyapi.com/v1/latest?apikey=" . env("CONVERTER_API_KEY") . "&currencies=" . $ratesOf . "&base_currency=USD";
    if(cache()->has($ratesOf)) {
        return cache()->get($ratesOf);
    } else {
        $result = Http::get($endpoint)->json("data.$ratesOf");
        cache()->put($ratesOf, $result, 100000000);
        return cache()->get($ratesOf);
    }
}