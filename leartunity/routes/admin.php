<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\Instructor\CourseController;
use App\Http\Controllers\Instructor\SectionController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\SwatchController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Models\User;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\FontController;


Route::get("/", [AdminController::class, "index"])->name("home.admin");
Route::get("/users", [UserController::class, "index"])->name("admin.user");


Route::put("/user/{user}/status", [UserController::class, "edit"])->name("admin.changeStatus");
Route::put("/user/{user}/ban", [UserController::class, "banManager"])->name("admin.manage.ban");

Route::get("/settings", [SettingController::class, "index"])->name("admin.setting");

Route::post("/swatch/add", [SwatchController::class, "store"])->name("admin.swatch.create");

Route::put("/font/update", [FontController::class, "update"])->name("admin.font.update");
Route::put("/color/update", [SettingController::class, "update"])->name("admin.color.update");

Route::get("/categories", [CategoryController::class, "index"])->name("category.index");
Route::put("/category/{without_scope_category}/status", [CategoryController::class, "editStatus"])->name("admin.category.changeStatus");
Route::post("/category/create", [CategoryController::class, "store"])->name("admin.category.create");
Route::put("/category/{without_scope_category}/update", [CategoryController::class, "update"])->name("admin.category.update");
Route::delete("/category/{without_scope_category}/delete", [CategoryController::class, "destroy"])->name("admin.category.delete");

Route::put("/change/quote", [QuoteController::class, "update"])->name("quote.rename");
