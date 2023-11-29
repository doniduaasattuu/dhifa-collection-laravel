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

    public function contact(Request $request)
    {
        return response()->view("contact", [
            "title" => "Contact",
            "user" => $request->session()->get("user"),
        ]);
    }
}
