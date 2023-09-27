<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home(Request $request)
    {

        $products = Product::query()->get();

        return response()->view("home", [
            "title" => "Dhifa Collection",
            "user" => $request->session()->get("user"),
            "products" => $products
        ]);
    }
}
