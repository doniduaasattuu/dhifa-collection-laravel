<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\DB;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();
        DB::table('order_details')->delete();
        DB::table('orders')->delete();
        DB::table('users')->where("email", "=", "test@gmail.com")->delete();
    }
}
