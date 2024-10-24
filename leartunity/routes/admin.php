<?php

use App\Http\Controllers\Admin\AnnouncementController;
use App\Http\Controllers\Admin\ApplicationController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\SwatchController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\FontController;
use App\Models\Course;


Route::get("/", [AdminController::class, "index"])->name("home.admin");


Route::controller(UserController::class)->name("admin.")->group(function() {
    Route::get("/users", "index")->name("user");
    Route::put("/user/{user}/status", "edit")->name("changeStatus");
    Route::put("/user/{user}/ban", "banManager")->name("manage.ban");
});

Route::controller(SettingController::class)->name("admin.")->group(function() {
    Route::get("/settings", "index")->name("setting");
    Route::put("/color/update", "update")->name("color.update");
});

Route::post("/swatch/add", [SwatchController::class, "store"])->name("admin.swatch.create");
Route::put("/font/update", [FontController::class, "update"])->name("admin.font.update");


Route::controller(CategoryController::class)->group(function() {
    Route::get("/categories", "index")->name("category.index");
    Route::put("/category/{without_scope_category}/status", "editStatus")->name("admin.category.changeStatus");
    Route::post("/category/create", "store")->name("admin.category.create");
    Route::put("/category/{without_scope_category}/update", "update")->name("admin.category.update");
    Route::delete("/category/{without_scope_category}/delete", "destroy")->name("admin.category.delete");
});

Route::put("/change/quote", [QuoteController::class, "update"])->name("quote.rename");

Route::controller(ApplicationController::class)->group(function() {
    Route::get("/applications", "index")->name("application");
    Route::get("/{application}/application", "show")->name("application.show");
    Route::get("/application/{file_name}/download", "file_download")->name("application.file.download");
    Route::patch("/application/{application}/approve", "approve")->name("application.approve");
    Route::patch("/application/{application}/reject", "reject")->name("application.reject");
});

Route::post("/announce/{course}", [AnnouncementController::class, "create"])->name("announce");
