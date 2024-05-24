<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class ReferralController extends Controller
{
    public function index() {
        $referrals = (User::find(auth()->id()))->referrals()->select("name", "email", "balance")->get();
        return view("User.Referral.index", compact("referrals"));        
    }
}
