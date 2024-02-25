<?php

use App\Http\Controllers\ContentController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\Authenticate;
use App\Models\Course;
use App\Models\Section;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CourseController;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\SearchController;

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
    // $course = Course::first();
    // $value = [
    //     [
    //         "name" => "Hashim Abbas",
    //         "status" => "true",
    //         "stars" => "4.3",
    //         "review" => "It was such an amazing course!"
    //     ]
    // ];
    // $course->reviews()->create([
    //     "reviews" => json_encode($value),
    //     "status" => true
    // ]);
    $array = [
        "Welcome to this section. This is what you will learn!" => 1,
        "What is a Vector?" => 1,
        "Let's create some vectors" => 1,
        "Using the [] brackets" => 1,
        "Vectorized operations" => 0,
        "The power of vectorized operations" => 1,
        "Functions in R" => 1,
        "Packages in R" => 1,
        "Section Recap" => 1,
        "HOMEWORK: Financial Statement Analysis" => 1,
        "Fundamentals of R" => 1
    ];
    $section = Section::where("id", 2)->first();
    $loop = 1;
    foreach($array as $lessonName => $status) {
        $section->contents()->create([
            "title" => $lessonName,
            "status" => 1,
            "is_paid" => $status,
            "content" => "dummy.mp4",
            "duration" => 400,
            "sequence" => $loop, 
            "description" => "[Mastering R Basics]: Learn the fundamental concepts and techniques of the R programming language, essential for data analysis and statistical modeling."
        ]);
        $loop++;
    }
    dd("Created!");
});

Route::group([ 'middleware' => ['web', "guest"] ], function() {
    Route::get("login", [SessionController::class, "index"]);
    Route::post("login", [SessionController::class, "create"])
        ->name("login");
});
Route::group([ "middleware" => "auth" ], function() {
    Route::get("logout", [SessionController::class, "logout"])->name("logout");
});

Route::get('/', [HomeController::class, "index"])->name("home");
Route::get("/course/{course:slug}", [CourseController::class, "get"])->name("course");

Route::get("content/{content:id}", [ContentController::class, "get"])->name("getContent");

Route::get("courses", [CourseController::class, "getCourses"])->name("getCourses");
Route::post("get/courses", [CourseController::class, "getData"])->name("getCourses");

Route::get("ajaxCourses", [CourseController::class, "ajax"]);

Route::get("/profile/{id}", [ProfileController::class, "index"]);

