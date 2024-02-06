<?php 


use App\Http\Controllers\Payment\StripeController;
use Illuminate\Support\Facades\Route;


Route::get("checkout/{id}", [StripeController::class, "checkout"])->name("checkout");
Route::get("checkout-success/{id}", [StripeController::class, "success"])->name("checkout-success");
Route::get("checkout-cancel", [StripeController::class, "cancel"])->name("checkout-cancel");