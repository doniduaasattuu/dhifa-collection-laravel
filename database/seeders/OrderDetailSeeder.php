<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::query()->with("order_open")->find("doni.duaasattuu@gmail.com");
        $order_open = $user->order_open;

        $order_detail1 = new OrderDetail();
        $order_detail1->order_id = $order_open->id;
        $order_detail1->product_id = 1;
        $order_detail1->price = 120000;
        $order_detail1->qty = 1;
        $order_detail1->amount = 120000;
        $order_detail1->save();

        $order_detail2 = new OrderDetail();
        $order_detail2->order_id = $order_open->id;
        $order_detail2->product_id = 2;
        $order_detail2->price = 110000;
        $order_detail2->qty = 1;
        $order_detail2->amount = 110000;
        $order_detail2->save();

        $order_closed = Order::query()->where("status", "Closed")->first();

        $order_detail3 = new OrderDetail();
        $order_detail3->order_id = $order_closed->id;
        $order_detail3->product_id = 3;
        $order_detail3->price = 150000;
        $order_detail3->qty = 1;
        $order_detail3->amount = 150000;
        $order_detail3->save();
    }
}
