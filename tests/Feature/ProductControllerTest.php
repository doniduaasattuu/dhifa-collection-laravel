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

    public function testOrderOpenRelations()
    {
        $user = User::query()->find("doni.duaasattuu@gmail.com");
        $order_open = $user->order_open;
        self::assertNotNull($order_open);
        self::assertEquals("doni.duaasattuu@gmail.com", $order_open->email);
        self::assertEquals("Open", $order_open->status);
        Log::info(json_encode($order_open, JSON_PRETTY_PRINT));

        $order_details = OrderDetail::where("order_id", "=", $order_open->id)->get();
        Log::info(json_encode($order_details, JSON_PRETTY_PRINT));
        foreach ($order_details as $order_detail) {
            if ($order_detail->product_id == 1) {
                $order_detail->qty = $order_detail->qty + 1;
                $order_detail->save();
            }
        }
    }

    // public function testOrderDetailRelations()
    // {
    //     $user = User::query()->find("doni.duaasattuu@gmail.com");
    //     $orders = $user->orders;
    //     self::assertNotNull($orders);
    //     self::assertEquals($orders->status, "Closed");
    //     Log::info(json_encode($orders, JSON_PRETTY_PRINT));
    // }
}
