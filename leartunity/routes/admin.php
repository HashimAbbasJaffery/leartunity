<?php

use App\Http\Controllers\ContentController;
use App\Http\Controllers\Instructor\CourseController;
use App\Http\Controllers\Instructor\SectionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;


Route::get("/", [AdminController::class, "index"])->name("home.admin");
