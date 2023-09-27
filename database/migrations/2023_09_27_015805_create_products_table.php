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
            $table->integer("id")->nullable(false)->autoIncrement();
            $table->string("name")->nullable(false);
            $table->integer("price")->nullable(false)->unsigned();
            $table->enum("category", ["Female", "Male"])->nullable(false);
            $table->integer("qty")->nullable(false)->unsigned();
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