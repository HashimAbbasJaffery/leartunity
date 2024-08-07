<?php
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LearningController;
use App\Http\Controllers\QuizController;
use App\Models\Certificate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\TrackerControler;

Route::get("/", [LearningController::class, "index"])->name("learn");
Route::get("course/{course:slug}/{content}", [LearningController::class, "get"])->name("watch.course");

Route::post("comment/{course:slug}/{content}/add", [CommentController::class, "create"])->name("create.comment");
Route::post("course/{content}/updateTracker/{course}", [TrackerControler::class, "update"])->name("update.tracker");

Route::post("course/quiz/{content}/submit", [QuizController::class, "submit"])->name("quiz.submit");

Route::get("certificate/{certificate_id}", function(Certificate $certificate) {
    $certificate_path = $certificate->certificate . "/certificate.pdf";
    return response()->download($certificate_path);
});
