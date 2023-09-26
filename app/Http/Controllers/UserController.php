<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
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
            return redirect("/");
        } else {
            return response()->view("user.login", [
                "title" => "Login",
                "error" => "Email or password is wrong! ⚠️ "
            ]);
        }
    }
}
