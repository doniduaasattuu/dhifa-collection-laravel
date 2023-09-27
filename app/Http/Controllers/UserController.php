<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
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

    // CHANGE PASSWORD
    public function changePassword(Request $request)
    {
        return response()->view("user.change-password", [
            "title" => "Change Password"
        ]);
    }

    public function doChangePassword(Request $request)
    {
        $email = $request->input("email");
        $current_password = $request->input("current_password");
        $new_password = $request->input("new_password");
        $confirm_new_password = $request->input("confirm_new_password");

        if (empty($email) || empty($current_password) || empty($new_password) || empty($confirm_new_password)) {
            return response()->view("user.change-password", [
                "title" => "Change Password",
                "error" => "All data is required! ⚠️"
            ]);
        }

        $user = User::query()->find($email);

        if ($user == null) {
            return response()->view("user.change-password", [
                "title" => "Change Password",
                "error" => "Email is not found! ⚠️"
            ]);
        } else {

            $correctPassword = $user->password;

            if ($correctPassword == $current_password) {

                if ($new_password == $confirm_new_password) {

                    $user->password = $new_password;
                    $user->update();

                    $products = Product::query()->get();

                    return response()->view("home", [
                        "title" => "Dhifa Collection",
                        "user" => $request->session()->get("user"),
                        "products" => $products,
                        "changed" => true,
                        "content_changed" => "password"
                    ]);
                } else {

                    return response()->view("user.change-password", [
                        "title" => "Change Password",
                        "error" => "Password is not match! ⚠️"
                    ]);
                }
            } else {

                return response()->view("user.change-password", [
                    "title" => "Change Password",
                    "error" => "Email or password is wrong! ⚠️"
                ]);
            }
        }
    }

    // CHANGE NAME
    public function changeName()
    {
        return response()->view("user.change-name", [
            "title" => "Change Name"
        ]);
    }

    public function doChangeName(Request $request)
    {
        $email = $request->input("email");
        $name = $request->input("name");

        if (empty($email) || empty($name)) {
            return response()->view("user.change-name", [
                "title" => "Change Name",
                "error" => "All data is required! ⚠️"
            ]);
        }

        $user = User::query()->find($email);

        if ($user == null) {
            return response()->view("user.change-name", [
                "title" => "Change Name",
                "error" => "Email is not found! ⚠️"
            ]);
        } else {

            $user->fullname = $name;
            $user->update();

            session(["user" => $user->fullname]);

            $products = Product::query()->get();

            return response()->view("home", [
                "title" => "Dhifa Collection",
                "user" => $request->session()->get("user"),
                "products" => $products,
                "changed" => true,
                "content_changed" => "name"
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
