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

    // CHANGE PASSWORD
    Route::get('/change-password', [\App\Http\Controllers\UserController::class, "changePassword"]);
    Route::post('/change-password', [\App\Http\Controllers\UserController::class, "doChangePassword"]);

    // CHANGE NAME
    Route::get('/change-name', [\App\Http\Controllers\UserController::class, "changeName"]);
    Route::post('/change-name', [\App\Http\Controllers\UserController::class, "doChangeName"]);

    // LOGOUT
    Route::get("/logout", [App\Http\Controllers\UserController::class, "logout"]);

    // PRODUCT
    Route::post("add-to-cart/{id}", [App\Http\Controllers\ProductController::class, "addToCart"]);
    Route::post("/delete-product", [App\Http\Controllers\ProductController::class, "deleteProductFromCart"]);
    Route::post("/delete-basket", [App\Http\Controllers\ProductController::class, "deleteBasket"]);
    Route::get("/cart", [App\Http\Controllers\ProductController::class, "cart"])->name("cart");
});

Route::middleware(OnlyGuestMiddleware::class)->group(function () {

    // LOGIN
    Route::get("/login", [App\Http\Controllers\UserController::class, "login"]);
    Route::post("/login", [App\Http\Controllers\UserController::class, "doLogin"]);

    // REGISTRATION
    Route::get("/register", [App\Http\Controllers\UserController::class, "registration"]);
    Route::post("/register", [App\Http\Controllers\UserController::class, "register"]);
});
