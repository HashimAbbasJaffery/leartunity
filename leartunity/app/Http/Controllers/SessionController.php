<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\LoginRequest;
use App\Services\StreakService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Inertia\Inertia;

class SessionController extends Controller
{
    public function index() {
        $token = csrf_token();
        return Inertia::render("Session/Login", [
            "token" => $token
        ]);
    }

    public function create(LoginRequest $request, StreakService $streak) {
        $credentials = $request->validated();
        if(Auth::attempt($credentials)) {
            $user = auth()->user();
            Auth::login($user);

            $request->session()->regenerate();
            $user = User::find(auth()->id());
            $last_login = $streak->checkAndUpdate($user);
            $intendedUrl = session()->get('url.intended');
            return $intendedUrl ? redirect($intendedUrl) : redirect("/courses");
        }

        return back()->with("message", "Invalid Username or Password");
    }
    public function logout(Request $request) {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return to_route("login");
    }
    public function register() {
        $referral_id = request()->get("id");
        $user = "";
        if($referral_id)
            $user = User::select("name", "id")->find($referral_id);

        return Inertia::render("Session/Register", [
            "referrer" => $user
        ]);
    }
}
