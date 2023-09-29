<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $products = [
            [
                "id" => 1,
                "name" => "Pepe Jeans",
                "price" => 120000,
                "category" => "Female",
                "stock" => 100,
            ], [
                "id" => 2,
                "name" => "The Run",
                "price" => 110000,
                "category" => "Female",
                "stock" => 100,
            ], [
                "id" => 3,
                "name" => "Style Vesture",
                "price" => 150000,
                "category" => "Female",
                "stock" => 100,
            ], [
                "id" => 4,
                "name" => "Sweet Rose",
                "price" => 165000,
                "category" => "Female",
                "stock" => 100,
            ], [
                "id" => 5,
                "name" => "Frock Works",
                "price" => 135000,
                "category" => "Female",
                "stock" => 100,
            ], [
                "id" => 6,
                "name" => "Honey Punch",
                "price" => 155000,
                "category" => "Female",
                "stock" => 100,
            ], [
                "id" => 7,
                "name" => "Nighty Nine",
                "price" => 170000,
                "category" => "Female",
                "stock" => 100,
            ], [
                "id" => 8,
                "name" => "The Goodly",
                "price" => 155000,
                "category" => "Female",
                "stock" => 100,
            ], [
                "id" => 9,
                "name" => "Fine Touch",
                "price" => 145000,
                "category" => "Female",
                "stock" => 100,
            ], [
                "id" => 10,
                "name" => "Simply Seattle",
                "price" => 180000,
                "category" => "Female",
                "stock" => 100,
            ], [
                "id" => 11,
                "name" => "Seemly Garb",
                "price" => 125000,
                "category" => "Female",
                "stock" => 100,
            ], [
                "id" => 12,
                "name" => "Style Wear",
                "price" => 170000,
                "category" => "Female",
                "stock" => 100,
            ]
        ];
        Product::query()->insert($products);
    }
}
