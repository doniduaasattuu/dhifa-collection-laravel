<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    // mengakses halaman login
    public function testLogin()
    {
        $this->get("/login")
            ->assertSeeText("Login")
            ->assertSeeText("Email address")
            ->assertSeeText("Password")
            ->assertSeeText("Submit")
            ->assertSeeText("Register here");
    }

    public function testDoLoginRequestEmpty()
    {
        $this->post("login", [
            "email" => "",
            "password" => "",
        ])
            ->assertSeeText("Login")
            ->assertSeeText("Email address")
            ->assertSeeText("Password")
            ->assertSeeText("Submit")
            ->assertSeeText("Register here")
            ->assertSeeText("Email and password is required!");
    }

    public function testDoLoginWrongPassword()
    {
        $this->post("login", [
            "email" => "doni.duaasattuu@gmail.com",
            "password" => "salah",
        ])
            ->assertSeeText("Login")
            ->assertSeeText("Email address")
            ->assertSeeText("Password")
            ->assertSeeText("Submit")
            ->assertSeeText("Register here")
            ->assertSeeText("Email or password is wrong!");
    }

    public function testDoLoginSuccess()
    {
        $this->post("login", [
            "email" => "doni.duaasattuu@gmail.com",
            "password" => "1234",
        ])
            ->assertRedirect("/");
    }

    public function testDoLoginRedirect()
    {
        $this->withSession([
            "user" => "Doni Darmawan"
        ])->post("/login", [
            "email" => "salah",
            "password" => "salah",
        ])->assertRedirect("/");
    }

    public function testGetHomeRedirect()
    {
        $this->get("/")
            ->assertRedirect("/login");
    }

    public function testFindUser()
    {
        $user = User::query()->find("doni.duaasattuu@gmail.com");

        self::assertNotNull($user);
        self::assertEquals("1234", $user->password);
        self::assertEquals("Doni Darmawan", $user->fullname);
    }
}
