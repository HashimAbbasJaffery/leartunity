<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionController extends Controller
{
    public function index() {
        return view("login");
    }

    public function create(LoginRequest $request) {
        $credentials = $request->validated();
        if(Auth::attempt($credentials)) {
            $user = auth()->user();
            Auth::login($user);

            $request->session()->regenerate();

            return redirect()->intended("/");
        }

        return redirect()->back()->with("error", "Invalid Username or Password");
    }
    public function logout(Request $request) {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return to_route("login");
    }
}
