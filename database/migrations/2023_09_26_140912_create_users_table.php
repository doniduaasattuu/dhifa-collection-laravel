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
        Schema::create('users', function (Blueprint $table) {
            $table->string("email", 50)->nullable(false)->primary();
            $table->string("password", 50)->nullable(false);
            $table->string("fullname", 100)->nullable(false);
            $table->string("address", 250)->nullable(false);
            $table->string("phone_number", 15)->nullable(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
