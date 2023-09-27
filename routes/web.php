<?php

use App\Http\Middleware\OnlyGuestMiddleware;
use App\Http\Middleware\OnlyMemberMiddleware;
use Illuminate\Support\Facades\Route;

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



Route::middleware(OnlyMemberMiddleware::class)->group(function () {
    // HOME
    Route::get('/', [\App\Http\Controllers\HomeController::class, "home"]);

    // LOGOUT
    Route::get("/logout", [App\Http\Controllers\UserController::class, "logout"]);
});

Route::middleware(OnlyGuestMiddleware::class)->group(function () {

    // LOGIN
    Route::get("/login", [App\Http\Controllers\UserController::class, "login"]);
    Route::post("/login", [App\Http\Controllers\UserController::class, "doLogin"]);

    // REGISTRATION
    Route::get("/register", [App\Http\Controllers\UserController::class, "registration"]);
    Route::post("/register", [App\Http\Controllers\UserController::class, "register"]);
});
