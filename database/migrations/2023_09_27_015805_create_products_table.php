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
        Schema::create('products', function (Blueprint $table) {
            $table->unsignedInteger("id")->autoIncrement();
            $table->string("name", 100)->nullable(false);
            $table->unsignedInteger("price")->nullable(false)->default(0);
            $table->enum("category", ["Female", "Male"])->nullable(false);
            $table->unsignedInteger("stock")->nullable(false)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
