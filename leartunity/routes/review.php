<?php

use App\Http\Controllers\ContentController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SectionController;
use Illuminate\Support\Facades\Route;


Route::post("/{course}", [ReviewController::class, "store"])->name("course.review");
Route::put("/{course}/update", [ReviewController::class, "update"])->name("review.update");
