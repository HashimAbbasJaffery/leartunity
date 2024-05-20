<?php 

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\BalanceController;
use App\Http\Controllers\User\FollowCOntroller;
use Illuminate\Support\Facades\Route;

Route::middleware("auth")->group(function() {

    Route::post("user/{profile:id}/follow", [FollowCOntroller::class, "store"])->name("follow");
    Route::post("user/{profile:id}/picture", [ProfileController::class, "changeProfileImage"]);

    Route::post("user/{user:id}/changeCurrency", [UserController::class, "changeCurrency"]);

    Route::get("balance/{user:id}", [BalanceController::class, "get"])->name("user.balance");

    Route::get("user/add-funds", [BalanceController::class, "add"])->name("add.balance");
    Route::post("user/add-funds", [BalanceController::class, "add"])->name("add.balance");

    Route::get("user/add/success", [BalanceController::class, "success_fund_transfer"])->name("user.add-fund.success");
});