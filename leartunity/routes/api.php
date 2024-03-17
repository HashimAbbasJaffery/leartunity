<?php

use App\Http\Controllers\SearchController;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get("/courses", function() {
    $courses = Course::whereStatus(1)->paginate(6);
    return json_encode($courses);
})->name("getApiCourses");


Route::get("/search", [SearchController::class, "get"])->name("search");



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
