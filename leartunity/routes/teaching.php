<?php

use App\Http\Controllers\ContentController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\SectionController;
use Illuminate\Support\Facades\Route;

Route::get("/", [CourseController::class, "index"]);
Route::get("/course/create", [CourseController::class, "create"]);
Route::post("/course/create", [CourseController::class, "store"])->name("course.create");
Route::get("/course/{course:slug}", [CourseController::class, "show"])->name("course.show");

Route::post("/section/{course:slug}/create", [SectionController::class, "store"])->name("section.create");
Route::post("/content/{section}/add", [ContentController::class, "store"])->name("content.store");