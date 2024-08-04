<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Inertia\Inertia;


// Reset-Password

Route::get("forgot-password", function() {
    return Inertia::render("Session/ForgotPassword");
});

Route::post("forgot-password", function(\Illuminate\Http\Request $request) {
    $request->validate([
        "email" => ["email", "required"]
    ]);

    $email = $request->only("email");
    $status = Password::sendResetLink($email);

    return $status === Password::RESET_LINK_SENT
                        ? back()->with("success", "We have sent you an email")
                        : back()->with("error", "We couldn't find your email");
})->middleware("guest")->name("forgot-password");

Route::get("reset-password/{token}", function(string $token) {
    return Inertia::render("Session/ResetPassword", [
        "token" => $token
    ]);
})->name("password.reset");

Route::post("reset-password", function(\Illuminate\Http\Request $request) {
    $request->validate([
        "email" => ["email", "required"],
        "password" => [ "required", "min:7", "confirmed" ]
    ]);
    $values = $request->only(["email", "password", "token", "password_confirmation"]);
    $status = Password::reset($values, function(User $user, string $password) {
        $user->forceFill([
            "password" => Hash::make($password)
        ]);

        $user->save();

        event(new PasswordReset($user));
    });

    return $status === Password::PASSWORD_RESET
                        ? to_route("login")->with("message", "Password has been changed")
                        : back()->with("message", "You probably wrote wrong email address");
})->name("reset-password");
