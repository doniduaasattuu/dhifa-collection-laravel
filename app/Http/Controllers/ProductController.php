<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\User;
use Illuminate\Cache\RedisTagSet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

use function PHPUnit\Framework\isNull;

class ProductController extends Controller
{

    public function addToCart(Request $request, string $id)
    {
        $email = session()->get("email");
        $user = User::query()->with("orders")->find($email);

        $orders = $user->orders;

        if (null == $orders->toArray()) {

            $order = Order::create([
                "email" => $email
            ]);

            $product = Product::query()->find($id);

            $order_detail = new OrderDetail();
            $order_detail->order_id = $order->id;
            $order_detail->product_id = $id;
            $order_detail->qty = 1;
            $order_detail->price = $product->price;
            $order_detail->amount = $product->price;
            $order_detail->save();

            $order->shopping_total = $order_detail->amount;
            $order->save();
        } else {

            // order sudah ada, lalu dilakukan pengecekan order
            $order_open = $user->order_open;
            $product = Product::query()->find($id);

            if (null != $order_open && $order_open->status == "Open") {

                $order_details = OrderDetail::where("order_id", "=", $order_open->id)->get();

                foreach ($order_details as $order_detail) {
                    if ($order_detail->product_id === $product->id) {
                        $order_detail->qty = $order_detail->qty + 1;
                        $order_detail->amount = $order_detail->qty * $order_detail->price;
                        $order_detail->save();

                        $order = Order::query()->find($order_open->id);
                        $order->shopping_total = $order_details->sum("amount");
                        $order->save();

                        return;
                    }
                }

                $order_detail = new OrderDetail();
                $order_detail->order_id = $order_open->id;
                $order_detail->product_id = $id;
                $order_detail->qty = 1;
                $order_detail->price = $product->price;
                $order_detail->amount = $product->price;
                $order_detail->save();

                $order_details = OrderDetail::where("order_id", "=", $order_open->id)->get();
                $order = Order::query()->find($order_open->id);
                $order->shopping_total = $order_details->sum("amount");
                $order->save();
            }
        }
    }

    public function cart()
    {
        $email = session()->get("email");
        $user = User::query()->find($email);
        $order = $user->order_open;
        $order_details = $user->order_details;

        return response()->view("cart", [
            "title" => "Cart",
            "order" => $order,
            "order_details" => $order_details
        ]);
    }

    public function deleteProductFromCart(Request $request)
    {
        $product_id = $request->input("product_id");
        $order_id =  $request->input("order_id");

        OrderDetail::query()->where("order_id", "=",  $order_id)->where("product_id", "=", $product_id)->delete();

        return redirect("cart");
    }
}
