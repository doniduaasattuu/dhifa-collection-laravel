<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    // LOGIN
    public function testGetLogin()
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

    // REGISTRATION
    public function testGetRegistration()
    {
        $this->get("/register")
            ->assertSeeText("Registration")
            ->assertSeeText("Email address")
            ->assertSeeText("Password")
            ->assertSeeText("Full Name")
            ->assertSeeText("Full Address")
            ->assertSeeText("Phone Number")
            ->assertSeeText("Sign Up")
            ->assertSeeText("Already have an account");
    }

    public function testRegistrationEmpty()
    {
        $this->post("/register", [])
            ->assertSeeText("All data is required!");
    }

    public function testRegistrationEmailDuplicate()
    {
        $this->post("/register", [
            "email" =>  "doni.duaasattuu@gmail.com",
            "password" =>  "1234",
            "fullname" =>  "Doni Darmawan",
            "address" =>  "Cikarang, Bekasi, Jawa Barat",
            "phone_number" => "08983456945",
        ])
            ->assertSeeText("Email is used!");
    }

    public function testRegistrationSuccess()
    {
        $this->post("/register", [
            "email" =>  "test@gmail.com",
            "password" =>  "1234",
            "fullname" =>  "Test",
            "address" =>  "Cikarang, Bekasi, Jawa Barat",
            "phone_number" => "08983456945",
        ])
            ->assertSeeText("Registration Success!");
    }
}
