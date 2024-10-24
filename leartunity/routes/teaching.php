<?php

use App\Http\Controllers\ContentController;
use App\Http\Controllers\Instructor\CourseController;
use App\Http\Controllers\Instructor\SectionController;
use App\Http\Controllers\QuizController;
use App\Models\Course;
use Illuminate\Support\Facades\Route;


Route::controller(SectionController::class)->name("section.")->group(function() {
    Route::delete("/section/{section}/delete", "destroy")->name("delete");
    Route::post("/section/{course_slug_o}/create", "store")->name("create");
    Route::put("/section/{section}/update", "update")->name("update");
});

Route::controller(ContentController::class)->name("content.")->group(function() {
    Route::post("/content/{section}/add", "store")->name("store");
    Route::delete("/content/{content}/delete", "destroy")->name("delete");
    Route::post("/content/{content}/update", "update")->name("update");
});

Route::controller(QuizController::class)->name("quiz.")->group(function() {
    Route::get("/content/{section}/quiz/add", "create")->name("get");
    Route::post("/content/{section}/quiz/add", "store")->name("store");;
});

Route::controller(CourseController::class)->group(function() {
    Route::get("/", "index")->name("instructor");
    Route::get("/course/create", "create");
    Route::put("/course/{course_o}/status", "changeStatus")->name("course.changeStatus");
    Route::get("/course/{course_slug_o}", "show")->name("course.show");
    Route::post("/course/store", "store")->name("course.create");
    Route::get("/course/{course_slug_o}/edit", "edit")->name("course.edit");
    Route::put("/course/{course_slug_o}/create", "update")->name("course.update");
    Route::delete("/course/{course:id}", "destroy")->name("course.delete");
});

Route::put("/course/{course:id}/awardables", function(Request $request, Course $course) {
   $course->is_certifiable = ! $course->is_certifiable;
   $course->save();
   return 1;
})->name("course.is_awardable");

Route::delete("/content/delete", [ContentController::class, "deleteMultiple"])->name("course.delete.many");
