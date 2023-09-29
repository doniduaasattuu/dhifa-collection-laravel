<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HomeControllerTest extends TestCase
{
    public function testGetHome()
    {
        $this->withSession([
            "user" => "Doni Darmawan",
        ])->get("/")
            ->assertSeeText("Search")
            ->assertSeeText("Home")
            ->assertSeeText("Dhifa Collection")
            ->assertSeeText("Add to cart")
            ->assertSeeText("2023");
    }
}
