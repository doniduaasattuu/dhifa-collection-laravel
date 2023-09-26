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
    Route::get('/', function () {
        return view('welcome');
    });

    Route::get("/logout", [App\Http\Controllers\UserController::class, "logout"]);
});

Route::middleware(OnlyGuestMiddleware::class)->group(function () {
    Route::get("/login", [App\Http\Controllers\UserController::class, "login"]);
    Route::post("/login", [App\Http\Controllers\UserController::class, "doLogin"]);
});
