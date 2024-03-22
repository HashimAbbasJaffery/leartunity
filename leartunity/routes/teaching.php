<?php

use App\Http\Controllers\ContentController;
use App\Http\Controllers\Instructor\CourseController;
use App\Http\Controllers\Instructor\SectionController;
use Illuminate\Support\Facades\Route;

Route::get("/", [CourseController::class, "index"])->name("instructor");

Route::delete("/section/{section}/delete", [SectionController::class, "destroy"])->name("section.delete");
Route::post("/section/{course_slug_o}/create", [SectionController::class, "store"])->name("section.create");
Route::put("/section/{section}/update", [SectionController::class, "update"])->name("section.update");

Route::post("/content/{section}/add", [ContentController::class, "store"])->name("content.store");
Route::delete("/content/{content}/delete", [ContentController::class, "destroy"])->name("content.delete");
Route::post("/content/{content}/update", [ContentController::class, "update"]);

Route::get("/course/create", [CourseController::class, "create"]);
Route::put("/course/{course_o}/status", [CourseController::class, "changeStatus"])->name("course.changeStatus");
Route::get("/course/{course_slug_o}", [CourseController::class, "show"])->name("course.show");
Route::post("/course/create", [CourseController::class, "store"])->name("course.create");
Route::get("/course/{course_slug_o}/edit", [CourseController::class, "edit"])->name("course.edit");
Route::put("/course/{course_slug_o}/create", [CourseController::class, "update"])->name("course.update");
Route::delete("/course/{course_slug_o}/delete", [CourseController::class, "destroy"])->name("course.delete");
