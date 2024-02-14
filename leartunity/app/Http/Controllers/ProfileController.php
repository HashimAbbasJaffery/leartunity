<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Profile;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    protected $courses;
    public function __construct() {
        $this->courses = Course::where("author_id", request()->id);
    }
    public function index(Request $request) {
        $user = auth()->user();
        $profile = Profile::where("user_id", $request->id)->first();
        $courses = $this->courses->get();
        $reviewCourses = $this->courses->whereHas("reviews")->get();
        $count = 0;
        $sum = 0;
        // dd($reviewCourses[0]->reviews->stars);

        foreach($reviewCourses as $reviewCourse) {
            $count++;
            $sum += $reviewCourse->reviews->stars;
        }
        $avgRating = 0;
        if($count)
            $avgRating = $sum / $count;

        $is_following = $user->follows_to()->where("follower_id", $user->id)->exists();
        $followersCount = $profile->user->follows->count();

        return view("guest.profile.profile", compact("count", "avgRating", "profile", "courses", "is_following", "followersCount"));
    }
}
