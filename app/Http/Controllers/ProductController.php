<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\User;
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

        // jika belum ada order sama sekali akan dibuatkan order baru
        if (null == $orders->toArray()) {

            $order = Order::create([
                "email" => $email
            ]);

            $product = Product::query()->find($id);

            OrderDetail::create([
                "order_id" => $order->id,
                "product_id" => $id,
                "qty" => 1,
                "price" => $product->price,
                "amount" => $product->price,
            ]);
        } else {

            // order sudah ada, lalu dilakukan pengecekan order
            $order_open = $user->order_open;
            $product = Product::query()->find($id);

            if (null != $order_open && $order_open->status == "Open") {

                $order_details = OrderDetail::where("order_id", "=", $order_open->id)->get();

                foreach ($order_details as $order_detail) {
                    if ($order_detail->product_id === $product->id) {
                        $order_detail->qty = $order_detail->qty + 1;
                        $order_detail->save();
                        return;
                    }
                }

                OrderDetail::create([
                    "order_id" => $order_open->id,
                    "product_id" => $id,
                    "qty" => 1,
                    "price" => $product->price,
                    "amount" => $product->price,
                ]);
            }


            // $status_order_open = $orders->toQuery()->where("status", "=", "Open")->get();

            // if (count($status_order_open)) {

            //     $product_already_on_cart = OrderDetail::query()->where("order_id", "=", $status_order_open[0]->id)->where("product_id", "=", $status_order_open[0]->id)->first();

            //     if ($product_already_on_cart != null) {
            //         // menambah quantity
            //     } else {
            //         $product = Product::query()->find($id);

            //         OrderDetail::create([
            //             "order_id" => $status_order_open[0]->id,
            //             "product_id" => $id,
            //             "qty" => 1,
            //             "price" => $product->price,
            //             "amount" => $product->price,
            //         ]);
            //     }
            // }
        }
    }
}
