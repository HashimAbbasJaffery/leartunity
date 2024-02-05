<?php

use App\Http\Middleware\Authenticate;
use App\Models\Course;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CourseController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Testing Routes 

Route::get("poly", function() {
    $course = Course::first();
    $value = [
        [
            "name" => "Hashim Abbas",
            "status" => "true",
            "stars" => "4.3"
        ]
    ];
    $course->reviews()->create([
        "reviews" => json_encode($value),
        "status" => true
    ]);

    dd("Created!");
});

Route::group([ 'middleware' => ['web', "guest"] ], function() {
    Route::get("login", [SessionController::class, "index"]);
    Route::post("login", [SessionController::class, "create"])
        ->name("login");
});
Route::group([ "middleware" => "auth" ], function() {
    Route::get("test", [SessionController::class, "test"])->name("test");
});

Route::get('/', [HomeController::class, "index"])->name("home");
Route::get("/course/{course:slug}", [CourseController::class, "get"]);
