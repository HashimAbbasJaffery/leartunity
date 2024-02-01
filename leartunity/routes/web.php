<?php

use App\Http\Middleware\Authenticate;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SessionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::group([ 'middleware' => ['web', "guest"] ], function() {
    Route::get("login", [SessionController::class, "index"]);
    Route::post("login", [SessionController::class, "create"])
        ->name("login");
});
Route::group([ "middleware" => "auth" ], function() {
    Route::get("test", [SessionController::class, "test"])->name("test");
});

Route::get('/', function () {
    return view('welcome');
});
