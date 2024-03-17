<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\Instructor\CourseController;
use App\Http\Controllers\Instructor\SectionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Models\User;


Route::get("/", [AdminController::class, "index"])->name("home.admin");
Route::get("/users", [UserController::class, "index"])->name("admin.user");


Route::put("/user/{user}/status", [UserController::class, "edit"])->name("admin.changeStatus");
Route::put("/user/{user}/ban", [UserController::class, "banManager"])->name("admin.manage.ban");

// Route::get()

