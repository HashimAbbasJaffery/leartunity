<?php
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LearningController;
use Illuminate\Support\Facades\Route;

Route::get("/", [LearningController::class, "index"])->name("learn");
Route::get("course/{course:slug}/{content}", [LearningController::class, "get"])->name("watch.course");

Route::post("comment/{course:slug}/{content}/add", [CommentController::class, "create"])->name("create.comment");