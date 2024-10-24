<?php


use App\Http\Controllers\Payment\StripeController;
use Illuminate\Support\Facades\Route;


Route::controller(StripeController::class)->group(function() {
    Route::get("checkout/{id}", "checkout")->name("checkout");
    Route::get("checkout-success/{id}", "success")->name("checkout-success");
    Route::get("checkout-cancel", "cancel")->name("checkout-cancel");
});
