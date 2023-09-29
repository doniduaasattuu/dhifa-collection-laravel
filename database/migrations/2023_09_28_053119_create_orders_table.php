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
        Schema::create('orders', function (Blueprint $table) {
            $table->uuid("id")->nullable(false)->primary();
            $table->string("email", 50)->nullable(false);
            $table->timestamp("order_date")->nullable(false)->useCurrent();
            $table->unsignedInteger("shopping_total")->nullable(false)->default(0);
            $table->enum("status", ['Open', 'Checkout', 'Verified', 'Closed'])->nullable(false)->default('Open');

            $table->foreign("email")->on("users")->references("email");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
