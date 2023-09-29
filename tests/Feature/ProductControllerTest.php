<?php

namespace Tests\Feature;

use App\Http\Controllers\ProductController;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
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
}
