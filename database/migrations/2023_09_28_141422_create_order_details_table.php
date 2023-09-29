<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_details', function (Blueprint $table) {
            $table->unsignedInteger("id")->autoIncrement();
            $table->char("order_id", 36)->nullable(false);
            $table->unsignedInteger("product_id")->nullable(false);
            $table->unsignedInteger("price")->nullable(false)->default(0);
            $table->unsignedTinyInteger("qty")->nullable(false)->default(0);
            $table->unsignedInteger("amount")->nullable(false)->default(0);

            $table->foreign("order_id")->references("id")->on("orders");
            $table->foreign("product_id")->references("id")->on("products");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_details');
    }
};
