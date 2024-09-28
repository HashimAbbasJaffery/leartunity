<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Pipeline\Pipeline;
use Inertia\Inertia;

class ReferralController extends Controller
{
    public function index() {
        $referrals = (User::find(auth()->id()))->referrals()->select("name", "email", "balance")->get();
        return Inertia::render("Referral/Index", [
            "referrals" => $referrals
        ]);
    }
}
