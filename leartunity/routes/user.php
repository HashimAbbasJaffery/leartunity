<?php 

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReferralController;
use App\Http\Controllers\User\ApplicationController;
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

    // Referral's routes

    Route::get("referrals", [ReferralController::class, "index"])->name("user.refer");


    // User Application Routes

    // Route::get("teacher/learn-more", [ApplicationController::class, "index"])->name("apply.learn-more");
    Route::view("teacher/learn-more", "User.Application.learn-more")->name("apply.learn-more");
    Route::get("apply", [ApplicationController::class, "index"])->name("apply");
    Route::post("apply", [ApplicationController::class, "store"])->name("apply");
});