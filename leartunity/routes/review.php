<?php

use App\Http\Controllers\ContentController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SectionController;
use Illuminate\Support\Facades\Route;

Route::controller(ReviewController::class)->group(function() {
    Route::post("/{course}", "store")->name("course.review");
    Route::put("/{course}/update", "update")->name("review.update");
});

