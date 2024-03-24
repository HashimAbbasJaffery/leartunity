<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\LoginRequest;
use App\Services\StreakService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class SessionController extends Controller
{
    public function index() {
        return view("login");
    }

    public function create(LoginRequest $request, StreakService $streak) {
        $credentials = $request->validated();
        if(Auth::attempt($credentials)) {
            $user = auth()->user();
            Auth::login($user);

            $request->session()->regenerate();
            $user = User::find(auth()->id());
            $last_login = $streak->checkAndUpdate($user);
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
    public function register() {
        return view("register");
    }
}
