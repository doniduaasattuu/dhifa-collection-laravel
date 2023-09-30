<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ProductController extends Controller
{

    public function addToCart(Request $request, string $id)
    {
        $email = session()->get("email");

        $user = User::query()->with("orders")->find($email);

        $orders = $user->orders;

        if (0 == count($orders)) {

            $orders = Order::create([
                "email" => $email
            ]);

            $product = Product::query()->find($id);

            OrderDetail::create([
                "order_id" => $orders->id,
                "product_id" => $id,
                "qty" => 1,
                "price" => $product->price,
                "amount" => $product->price,
            ]);

            session(["successfully_added" => "true"]);
            return Redirect::back();
        } else {

            $status_order_open = $orders->toQuery()->where("status", "=", "Open")->get();

            if (count($status_order_open)) {

                $product_already_on_cart = OrderDetail::query()->where("order_id", "=", $status_order_open[0]->id)->where("product_id", "=", $status_order_open[0]->id)->first();

                if ($product_already_on_cart != null) {
                    // menambah quantity
                } else {
                    $product = Product::query()->find($id);

                    OrderDetail::create([
                        "order_id" => $status_order_open[0]->id,
                        "product_id" => $id,
                        "qty" => 1,
                        "price" => $product->price,
                        "amount" => $product->price,
                    ]);
                }
            }
        }
    }
}
