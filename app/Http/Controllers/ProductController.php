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

            return response()->json([
                "message" => "Success"
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
                        $order_detail->amount = $order_detail->qty * $order_detail->price;
                        $order_detail->save();

                        $order = Order::query()->find($order_open->id);
                        $order->shopping_total = $order_details->sum("amount");
                        $order->save();

                        return response()->json([
                            "message" => "Success"
                        ]);
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

                return response()->json([
                    "message" => "Success"
                ]);
            } else {

                return response()->json([
                    "message" => "Failed"
                ]);
                // $order = Order::create([
                //     "email" => $email
                // ]);

                // $product = Product::query()->find($id);

                // $order_detail = new OrderDetail();
                // $order_detail->order_id = $order->id;
                // $order_detail->product_id = $id;
                // $order_detail->qty = 1;
                // $order_detail->price = $product->price;
                // $order_detail->amount = $product->price;
                // $order_detail->save();

                // $order->shopping_total = $order_detail->amount;
                // $order->save();
            }
        }
    }

    public function cart()
    {
        $email = session()->get("email");
        $user = User::query()->with("orders", "order_open", "order_checkout", "order_verified", "order_details")->find($email);
        $order_open = $user->order_open;
        $order_checkout = $user->order_checkout;
        $order_verified = $user->order_verified;

        if (!empty($order_open) && !empty($order_open->order_details) && count($order_open->order_details) >= 1) {
            $order_details = $order_open->order_details;

            return response()->view("cart", [
                "title" => "Cart",
                "order" => $order_open,
                "order_details" => $order_details
            ]);
        } else if (!empty($order_checkout) && !empty($order_checkout->order_details)) {
            return response()->view("checkout", [
                "title" => "Checkout",
                "order" => $order_checkout
            ]);
        } else if (!empty($order_verified) && !empty($order_verified->order_details)) {
            return response()->view("checkout", [
                "title" => "Checkout",
                "order" => $order_verified,
                "verified" => true
            ]);
        } else {
            return response()->view("empty-cart", [
                "title" => "Cart",
            ]);
        }
    }

    public function deleteProductFromCart(Request $request)
    {
        $product_id = $request->input("product_id");
        $order_id =  $request->input("order_id");

        OrderDetail::query()->where("order_id", "=",  $order_id)->where("product_id", "=", $product_id)->delete();

        return redirect("cart");
    }

    public function deleteBasket(Request $request)
    {
        $email = session()->get("email");
        $user = User::query()->find($email);
        $order_id =  $request->input("order_id");

        OrderDetail::query()->where("order_id", "=",  $order_id)->delete();
        // Order::query()->find($order_id)->where("email", "=", $email)->delete();
        return redirect("cart");
    }

    public function decrementProductFromCart(Request $request, string $id, string $order_id)
    {

        $product = OrderDetail::query()->where("order_id", "=",  $order_id)->where("product_id", "=", $id)->first();

        $product->qty = $product->qty - 1;
        $product->amount = $product->price * $product->qty;
        $product->update();

        $order_open = Order::query()->find($order_id);
        $order_open->shopping_total = $order_open->order_details->sum("amount");
        $order_open->update();
    }

    public function incrementProductFromCart(Request $request, string $id, string $order_id)
    {

        $product = OrderDetail::query()->where("order_id", "=",  $order_id)->where("product_id", "=", $id)->first();

        $product->qty = $product->qty + 1;
        $product->amount = $product->price * $product->qty;
        $product->update();

        $order_open = Order::query()->find($order_id);
        $order_open->shopping_total = $order_open->order_details->sum("amount");
        $order_open->update();
    }

    public function checkout(Request $request, string $order_id, string $total_payment)
    {
        $order = Order::query()->find($order_id);
        $order->shopping_total = $total_payment;
        $order->status = "Checkout";
        $order->update();

        return redirect("cart");
    }

    public function cancelOrder(Request $request, string $order_id)
    {
        $order = Order::query()->find($order_id);
        $order->status = "Open";
        $order->update();

        return redirect("cart");
    }

    public function uploadResi(Request $request, string $order_id)
    {
        $order = Order::query()->find($order_id);
        $order->status = "Verified";
        $order->update();

        return redirect("cart");
    }
}
