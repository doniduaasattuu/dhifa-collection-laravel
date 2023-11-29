<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Telegram\Bot\Laravel\Facades\Telegram;

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

    public function sendMessage(Request $request): Response
    {
        $name = $request->input("name");
        $email = $request->input("email");
        $message = $request->input("message");
        $time = Carbon::now()->timezone("Asia/Jakarta");


        $messageResult = $time->toDateTimeString() . "\n\nName : $name" . "\n" . "Email : $email" . "\n" . "Message : $message";

        $response = Telegram::sendMessage([
            'chat_id' => '@donidarmawanportfolioweb',
            'text' => $messageResult
        ]);

        $messageId = $response->getMessageId();

        return response()->view("contact", [
            "title" => "Contact",
            "user" => $request->session()->get("user"),
            "success" => true
        ])
            ->withHeaders(["Author" => "Doni Darmawan"]);
    }
}
