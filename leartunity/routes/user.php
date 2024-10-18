<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReferralController;
use App\Http\Controllers\User\ApplicationController;
use App\Http\Controllers\User\BalanceController;
use App\Http\Controllers\User\FollowCOntroller;
use App\Models\Content;
use App\Models\User;
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


    Route::get("video/{filename}", function($fileName) {
        $path = storage_path("app/videos/$fileName");

        if (!File::exists($path)) {
            abort(404, 'Video not found.');
        }

        $user = User::find(auth()->id());
        $course_stripe_id = (Content::firstWhere("content", $fileName))->section->course->stripe_id;
        $is_authorized = $user->purchases()->where("purchase_product_id", $course_stripe_id)->exists();
        if(!$is_authorized) return;

        // Stream the video file
        return response()->stream(function () use ($path) {
            $stream = fopen($path, 'rb');
            fpassthru($stream);
            fclose($stream);
        }, 200, [
            'Content-Type' => 'video/mp4', // Adjust content type based on the file type
            'Content-Length' => File::size($path),
            'Accept-Ranges' => 'bytes',
        ]);
    })->name("video.get");

});
