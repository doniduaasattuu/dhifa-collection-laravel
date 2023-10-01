<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class DeleteTableTest extends TestCase
{
    public function testDelete()
    {
        DB::table('order_details')->delete();
        DB::table('orders')->delete();

        self::assertNotNull(User::query()->find("doni.duaasattuu@gmail.com"));
    }
}
