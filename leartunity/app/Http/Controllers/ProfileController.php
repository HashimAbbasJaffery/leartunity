<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Profile;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index(Request $request) {
        $profile = Profile::where("user_id", $request->id)->first();
        $courses = Course::where("author_id", $request->id)->get();
        return view("guest.profile.profile", compact("profile", "courses"));
    }
}
