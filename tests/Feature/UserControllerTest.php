<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\User;
use Database\Seeders\OrderDetailSeeder;
use Database\Seeders\OrderSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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
            ->assertSeeText("Sign In")
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
            ->assertSeeText("Sign In")
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
            ->assertSeeText("Sign In")
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

    // CHANGE PASSWORD
    public function testGetChangePassword()
    {
        $this->withSession([
            "user" => "Doni Darmawan"
        ])
            ->get("/change-password")
            ->assertSeeText("Change Password")
            ->assertSeeText("Your Email")
            ->assertSeeText("Current Password")
            ->assertSeeText("New Password")
            ->assertSeeText("Confirm New Password")
            ->assertSeeText("Change Password");
    }

    public function testDoChangePasswordRequestEmpty()
    {
        $this->withSession([
            "user" => "Doni Darmawan"
        ])->post("/change-password", [
            "email" => "doni.duaasattuu@gmail.com",
            "current_password" => "1234"
        ])
            ->assertSeeText("All data is required!");
    }

    public function testDoChangePasswordWrongEmail()
    {
        $this->withSession([
            "user" => "Doni Darmawan"
        ])->post("/change-password", [
            "email" => "tidak_ada@gmail.com",
            "current_password" => "1234",
            "new_password" => "rahasia",
            "confirm_new_password" => "rahasia",
        ])
            ->assertSeeText("Email is not found!");
    }

    public function testDoChangePasswordWrongPassword()
    {
        $this->withSession([
            "user" => "Doni Darmawan"
        ])->post("/change-password", [
            "email" => "doni.duaasattuu@gmail.com",
            "current_password" => "salah",
            "new_password" => "rahasia",
            "confirm_new_password" => "rahasia",
        ])
            ->assertSeeText("Email or password is wrong!");
    }

    public function testDoChangePasswordNotMatch()
    {
        $this->withSession([
            "user" => "Doni Darmawan"
        ])->post("/change-password", [
            "email" => "doni.duaasattuu@gmail.com",
            "current_password" => "1234",
            "new_password" => "salah",
            "confirm_new_password" => "rahasia",
        ])
            ->assertSeeText("Password is not match!");
    }

    public function testDoChangePasswordSuccess()
    {
        $this->withSession([
            "user" => "Doni Darmawan"
        ])->post("/change-password", [
            "email" => "doni.duaasattuu@gmail.com",
            "current_password" => "1234",
            "new_password" => "password_baru",
            "confirm_new_password" => "password_baru",
        ])
            ->assertSeeText("Success!")
            ->assertSeeText("Your password has been changed successfully.")
            ->assertSeeText("Close");

        $user = User::query()->find("doni.duaasattuu@gmail.com");
        $user->password = "1234";
        $user->update();
    }

    // CHANGE NAME
    public function testGetChangeName()
    {
        $this->withSession([
            "user" => "Doni Darmawan"
        ])->get("/change-name")
            ->assertSeeText("Change Name")
            ->assertSeeText("Your Email")
            ->assertSeeText("New Fullname")
            ->assertSeeText("Change Username");
    }

    public function testDoChangeNameRequestEmpty()
    {
        $this->withSession([
            "user" => "Doni Darmawan"
        ])->post("/change-name", [])
            ->assertSeeText("All data is required!");
    }

    public function testDoChangeNameWrongEmail()
    {
        $this->withSession([
            "user" => "Doni Darmawan"
        ])->post("/change-name", [
            "email" => "tidak_ada@gmail.com",
            "name" => "Doni Darmawan Wibisono"
        ])
            ->assertSeeText("Email is not found!");
    }

    public function testDoChangeNameSuccess()
    {
        $this->withSession([
            "user" => "Doni Darmawan"
        ])->post("/change-name", [
            "email" => "doni.duaasattuu@gmail.com",
            "name" => "Doni Darmawan Wibisono"
        ])
            ->assertSeeText("Success!")
            ->assertSeeText("Your name has been changed successfully.")
            ->assertSeeText("Close");

        $user = User::query()->find("doni.duaasattuu@gmail.com");
        $user->fullname = "Doni Darmawan";
        $user->save();
    }

    public function testUserOrderRelation()
    {

        $this->seed([OrderSeeder::class, OrderDetailSeeder::class]);

        $user = User::query()->find("doni.duaasattuu@gmail.com");
        $orders = $user->orders;
        self::assertCount(4, $orders);
        self::assertNotNull($orders);
    }

    public function testHasManyThrough()
    {
        $user = User::query()->with(["orders", "order_details"])->find("doni.duaasattuu@gmail.com");;

        self::assertNotNull($user);
        Log::info(json_encode($user, JSON_PRETTY_PRINT));
    }
}
