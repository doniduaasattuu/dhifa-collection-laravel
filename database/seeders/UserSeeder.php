<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            "email" => "doni.duaasattuu@gmail.com",
            "password" => "1234",
            "fullname" => "Doni Darmawan",
            "address" => "Cikarang, Bekasi, Jawa Barat",
            "phone_number" => "08983456945",
        ]);
    }
}
