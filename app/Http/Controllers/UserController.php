<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // LOGIN
    public function login()
    {
        return response()->view("user.login", [
            "title" => "Login"
        ]);
    }

    public function doLogin(Request $request)
    {
        $email = $request->input("email");
        $password = $request->input("password");

        if (empty($email) or empty($password)) {

            return response()->view("user.login", [
                "title" => "Login",
                "error" => "Email and password is required! ⚠️ "
            ]);
        }

        $user = User::query()->find($email);

        if ($user != null && $user->password == $password) {
            session(["user" => $user->fullname]);
            return redirect("/");
        } else {
            return response()->view("user.login", [
                "title" => "Login",
                "error" => "Email or password is wrong! ⚠️ "
            ]);
        }
    }

    // REGISTRATION
    public function registration()
    {
        return response()->view("user.register", [
            "title" => "Registration"
        ]);
    }

    public function register(Request $request)
    {
        $email = $request->input("email");
        $password = $request->input("password");
        $fullname = $request->input("fullname");
        $address = $request->input("address");
        $phone_number = $request->input("phone_number");

        if (
            empty($email) ||
            empty($password) ||
            empty($fullname) ||
            empty($address) ||
            empty($phone_number)
        ) {
            return response()->view("user.register", [
                "title" => "Registration",
                "error_required" => "All data is required! ⚠️"
            ]);
        }

        $user = User::query()->find($email);

        if ($user == null) {

            User::create([
                "email" =>  $email,
                "password" =>  $password,
                "fullname" =>  $fullname,
                "address" =>  $address,
                "phone_number" => $phone_number,
            ]);

            return response()->view("user.login", [
                "title" => "Login",
                "registration_success" => true
            ]);
        } else {
            return response()->view("user.register", [
                "title" => "Registration",
                "error_email_duplicate" => "Email is used! ⚠️"
            ]);
        }
    }

    // LOGOUT
    public function logout(Request $request)
    {
        $request->session()->forget('user');
        return redirect("/");
    }
}
