<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\OnlyGuestMiddleware;
use App\Http\Middleware\OnlyMemberMiddleware;
use Illuminate\Support\Facades\App;
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
    Route::get('/', [HomeController::class, "home"]);

    // CHANGE PASSWORD
    Route::get('/change-password', [UserController::class, "changePassword"]);
    Route::post('/change-password', [UserController::class, "doChangePassword"]);

    // CHANGE NAME
    Route::get('/change-name', [UserController::class, "changeName"]);
    Route::post('/change-name', [UserController::class, "doChangeName"]);

    // LOGOUT
    Route::get("/logout", [UserController::class, "logout"]);

    // PRODUCT
    Route::post("add-to-cart/{id}", [ProductController::class, "addToCart"]);
    Route::post("/delete-product", [ProductController::class, "deleteProductFromCart"]);
    Route::post("/decrement-product/{id}/{order_id}", [ProductController::class, "decrementProductFromCart"]);
    Route::post("/increment-product/{id}/{order_id}", [ProductController::class, "incrementProductFromCart"]);
    Route::post("/delete-basket", [ProductController::class, "deleteBasket"]);
    Route::post("/checkout/{order_id}/{total_payment}", [ProductController::class, "checkout"]);
    Route::post("/cancel-order/{order_id}", [ProductController::class, "cancelOrder"]);
    Route::post("/upload-resi/{order_id}", [ProductController::class, "uploadResi"]);
    Route::get("/cart", [ProductController::class, "cart"])->name("cart");

    // CONTACT
    Route::get("/contact", [HomeController::class, "contact"]);
    Route::post("/contact", [HomeController::class, "sendMessage"]);
});

Route::middleware(OnlyGuestMiddleware::class)->group(function () {

    // LOGIN
    Route::get("/login", [UserController::class, "login"]);
    Route::post("/login", [UserController::class, "doLogin"]);

    // REGISTRATION
    Route::get("/register", [UserController::class, "registration"]);
    Route::post("/register", [UserController::class, "register"]);
});
