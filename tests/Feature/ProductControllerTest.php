<?php

namespace Tests\Feature;

use App\Http\Controllers\ProductController;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\User;
use Database\Seeders\OrderDetailSeeder;
use Database\Seeders\OrderSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{

    public function testFindOrderNull()
    {
        $user = User::query()->find("doni.duaasattuu@gmail.com");
        $orders = $user->orders;

        self::assertCount(0, $orders);
    }

    public function testFindOrderAvailable()
    {
        $this->seed([OrderSeeder::class]);

        $user = User::query()->find("doni.duaasattuu@gmail.com");
        $orders = $user->orders;

        self::assertCount(4, $orders);
    }

    public function testFindOrderOpen()
    {
        $this->seed([OrderSeeder::class]);

        $user = User::query()->find("doni.duaasattuu@gmail.com");
        $order_open = $user->order_open; // hasOne

        self::assertNotNull($order_open->id);
        self::assertNotNull($order_open->email);
        self::assertNotNull($order_open->order_date);
        self::assertNotNull($order_open->shopping_total);
        self::assertNotNull($order_open->status);
        self::assertEquals("2020-10-10 10:10:10", $order_open->order_date);
        self::assertEquals("Open", $order_open->status);
    }

    public function testFindOrderDetailNull()
    {
        $this->seed([OrderSeeder::class]);

        $user = User::query()->find("doni.duaasattuu@gmail.com");
        $order_details = $user->order_details;

        self::assertCount(0, $order_details);
        Log::info(json_encode($order_details, JSON_PRETTY_PRINT)); // []
    }

    public function testFindOrderDetailAvailable()
    {
        $this->seed([OrderSeeder::class, OrderDetailSeeder::class]);

        $user = User::query()->with("order_details")->find("doni.duaasattuu@gmail.com");
        $order_details = $user->order_details;

        self::assertCount(3, $order_details);
        self::assertEquals(1, $order_details[0]->product_id);
        self::assertEquals(120000, $order_details[0]->price);
        self::assertEquals(1, $order_details[0]->qty);

        self::assertEquals(2, $order_details[1]->product_id);
        self::assertEquals(110000, $order_details[1]->price);
        self::assertEquals(1, $order_details[1]->qty);
    }

    public function testOrderDetails()
    {

        $this->seed([OrderSeeder::class, OrderDetailSeeder::class]);

        $user = User::query()->with("orders", "order_open", "order_details")->find("doni.duaasattuu@gmail.com");
        $order_open = $user->order_open;
        $order_details = $order_open->order_details;

        self::assertNotNull($order_details);
        Log::info(json_encode($order_details, JSON_PRETTY_PRINT));
    }

    public function testFindOrderDetailClosed()
    {
        $this->seed([OrderSeeder::class, OrderDetailSeeder::class]);

        $user = User::query()->find("doni.duaasattuu@gmail.com");
        $orders = $user->orders;

        $order_closed = $orders->toQuery()->with("order_details")->where("status", "=", "Closed")->first();
        self::assertNotNull($order_closed);

        Log::info(json_encode($order_closed, JSON_PRETTY_PRINT));

        $order_details = $order_closed->order_details;
        self::assertNotNull($order_details);

        self::assertCount(1, $order_details);
        self::assertEquals(3, $order_details->first()->product_id);
        self::assertEquals(150000, $order_details->first()->price);
        self::assertEquals(1, $order_details->first()->qty);
        self::assertEquals(150000, $order_details->first()->amount);
    }

    public function testUserRelations()
    {
        $this->seed([OrderSeeder::class, OrderDetailSeeder::class]);

        $user = User::query()->with("orders", "order_details", "order_open")->find("doni.duaasattuu@gmail.com");
        self::assertNotNull($user);
    }

    public function testOrderDetailRelationProduct()
    {
        $this->seed([OrderSeeder::class, OrderDetailSeeder::class]);

        $user = User::query()->with("orders", "order_details")->find("doni.duaasattuu@gmail.com");
        $orders = $user->orders;

        $order_closed = $orders->toQuery()->with("order_details")->where("status", "=", "Closed")->first();
        self::assertNotNull($order_closed);

        $order_details = $order_closed->order_details;

        self::assertCount(1, $order_details);
        self::assertEquals(3, $order_details->first()->product_id);
        self::assertEquals(150000, $order_details->first()->price);
        self::assertEquals(1, $order_details->first()->qty);
        self::assertEquals(150000, $order_details->first()->amount);

        $product = $order_details->first()->product;

        self::assertEquals($product->id, 3);
        self::assertEquals($product->name, "Style Vesture");
        self::assertEquals($product->price, 150000);
        self::assertEquals($product->category, "Female");
        self::assertEquals($product->stock, 100);
    }

    // ROUTE WEB
    public function testEmptyCart()
    {
        $this->withSession([
            "user" => "Doni Darmawan",
            "email" => "doni.duaasattuu@gmail.com"
        ])->get("/cart")
            ->assertSeeText("Your cart is empty");
    }

    public function testGetCart()
    {
        $this->seed([OrderSeeder::class, OrderDetailSeeder::class]);

        Order::query()->where("status", "=", "Checkout")->first()->delete();

        $this->withSession([
            "user" => "Doni Darmawan",
            "email" => "doni.duaasattuu@gmail.com"
        ])->get("/cart")
            ->assertSeeText("Pepe Jeans")
            ->assertSeeText("The Run")
            ->assertSeeText("Cart details")
            ->assertSeeText("(2 items)")
            ->assertSeeText("230000")
            ->assertSeeText("Shipping price")
            ->assertSeeText("Total payment")
            ->assertSeeText("Payment method")
            ->assertSeeText("Checkout");
    }

    public function testAddToCart()
    {
        $this->seed([OrderSeeder::class]);

        Order::query()->where("status", "=", "Checkout")->first()->delete();

        $this->withSession([
            "user" => "Doni Darmawan",
            "email" => "doni.duaasattuu@gmail.com"
        ])->post("/add-to-cart/3");

        $this->get("/cart")
            ->assertSeeText("Style Vesture")
            ->assertSeeText("(1 items)")
            ->assertSeeText("Checkout");
    }

    public function testDeleteProductFromCart()
    {
        $this->testGetCart();

        $user = User::query()->find("doni.duaasattuu@gmail.com");
        $order_open = $user->order_open;

        $this->withSession([
            "user" => "Doni Darmawan",
            "email" => "doni.duaasattuu@gmail.com"
        ])->post("/delete-product", [
            "product_id" => 1,
            "order_id" => $order_open->id
        ])->assertRedirect("cart");
    }

    public function testDeleteBasket()
    {
        $this->testGetCart();

        $user = User::query()->find("doni.duaasattuu@gmail.com");
        $order_open = $user->order_open;

        $this->withSession([
            "user" => "Doni Darmawan",
            "email" => "doni.duaasattuu@gmail.com"
        ])->post("/delete-product", [
            "product_id" => 1,
            "order_id" => $order_open->id
        ])->assertRedirect("cart")
            ->assertStatus(302);
    }

    public function testDecrementProductFromCart()
    {
        $this->seed([OrderSeeder::class, OrderDetailSeeder::class]);

        $user = User::query()->find("doni.duaasattuu@gmail.com");
        $order_open = $user->order_open;

        $product = OrderDetail::query()->where("order_id", "=",  $order_open->id)->where("product_id", "=", 2)->first();
        self::assertNotNull($product);
        self::assertEquals(1, $product->qty);

        $product->qty = $product->qty + 1;
        $product->amount = $product->price * $product->qty;
        $product->update();

        $order_open->shopping_total = $order_open->order_details->sum("amount");
        $order_open->update();

        self::assertEquals(2, $product->qty);
        self::assertEquals(220000, $product->amount);

        self::assertEquals(340000, $order_open->shopping_total);
    }

    public function testCheckout()
    {
        $this->seed([OrderSeeder::class, OrderDetailSeeder::class]);

        $user = User::query()->find("doni.duaasattuu@gmail.com");
        $order_open = $user->order_open;

        $order = Order::query()->find($order_open->id);
        self::assertEquals("Open", $order->status);
    }

    public function testOrderCheckout()
    {
        $this->seed([OrderSeeder::class, OrderDetailSeeder::class]);

        $user = User::query()->find("doni.duaasattuu@gmail.com");
        $checkout = $user->order_checkout;

        self::assertNotNull($checkout);
        Log::info(json_encode($checkout, JSON_PRETTY_PRINT));
    }
}
