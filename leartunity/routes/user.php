<?php 

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\FollowCOntroller;
use Illuminate\Support\Facades\Route;

Route::middleware("auth")->group(function() {

    Route::post("user/{profile:id}/follow", [FollowCOntroller::class, "store"])->name("follow");
    Route::post("user/{profile:id}/picture", [ProfileController::class, "changeProfileImage"]);

    Route::post("user/{user:id}/changeCurrency", [UserController::class, "changeCurrency"]);
});