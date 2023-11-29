<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();
        DB::table('order_details')->truncate();
        DB::table('orders')->delete();
        DB::table('products')->delete();
        DB::table('users')->delete();

        $this->call([
            ProductSeeder::class,
            UserSeeder::class,
        ]);
    }
}
