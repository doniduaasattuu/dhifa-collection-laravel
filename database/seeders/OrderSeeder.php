<?php

namespace Database\Seeders;

use App\Models\Order;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $order_open = new Order();
        $order_open->email = "doni.duaasattuu@gmail.com";
        $order_open->order_date = "2020-10-10 10:10:10";
        $order_open->status = "Open";
        $order_open->save();

        // $order_open_1 = new Order();
        // $order_open_1->email = "doni.duaasattuu@gmail.com";
        // $order_open_1->order_date = "2020-10-10 10:10:10";
        // $order_open_1->status = "Open";
        // $order_open_1->save();

        $order_checkout = new Order();
        $order_checkout->email = "doni.duaasattuu@gmail.com";
        $order_checkout->status = "Checkout";
        $order_checkout->save();

        $order_verified = new Order();
        $order_verified->email = "doni.duaasattuu@gmail.com";
        $order_verified->status = "Verified";
        $order_verified->save();

        $order_closed = new Order();
        $order_closed->email = "doni.duaasattuu@gmail.com";
        $order_closed->status = "Closed";
        $order_closed->save();
    }
}
