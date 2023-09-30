<?php

namespace Tests\Feature;

use App\Http\Controllers\ProductController;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    public function testFindOrders()
    {
        $user = User::query()->find("doni.duaasattuu@gmail.com");
        $orders = $user->orders;

        self::assertNotNull($orders);
        Log::info(json_encode($orders, JSON_PRETTY_PRINT));
    }

    public function testFindOrderOpen()
    {
        $user = User::query()->find("doni.duaasattuu@gmail.com");
        $status = $user->orders;

        self::assertNotNull($status);
        self::assertCount(1, $status);
        Log::info(json_encode($status, JSON_PRETTY_PRINT));

        $status_open = $status->toQuery()->where("status", 'Open')->get();
        self::assertCount(1, $status_open);
        Log::info(json_encode($status_open, JSON_PRETTY_PRINT));
    }

    public function testCheckStatusOpen()
    {
        $user = User::query()->find("doni.duaasattuu@gmail.com");

        $orders = $user->orders;

        self::assertCount(0, $orders);

        // $status_order_open = $orders->toQuery()->where("status", "=", "Open")->get();
        // self::assertTrue($status_order_open != null);
        // self::assertFalse($status_order_open == null);

        // $productController = new ProductController();
        // self::assertTrue($productController->checkStatusOpen("doni.duuasattuu@gmail.com"));
    }

    public function testDeleteOrderDetailAndOrders()
    {
        DB::table('order_details')->delete();
        DB::table('orders')->delete();

        self::assertCount(0, Order::query()->get());
    }

    public function testProductAlreadyOnCart()
    {
        $product_already_on_cart = OrderDetail::query()->where("product_id", "=", "1")->first();
        self::assertNotNull($product_already_on_cart);
        Log::info(json_encode($product_already_on_cart));
    }

    public function testProductNotAlreadyOnCart()
    {
        $product_not_already_on_cart = OrderDetail::query()->where("product_id", "=", "90")->first();
        self::assertNull($product_not_already_on_cart);
        Log::info(json_encode($product_not_already_on_cart));
    }

    public function testFindOnCart()
    {
        $product_already_on_cart = OrderDetail::query()->where("order_id", "=", "9a410913-4a2f-4608-9e33-efda023de89e")->where("product_id", "=", "1")->get();
        self::assertNotNull($product_already_on_cart);
        self::assertCount(1, $product_already_on_cart);
        Log::info(json_encode($product_already_on_cart));
    }
}
