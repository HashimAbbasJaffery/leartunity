<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\File as FileValidation;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

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
    public function changeProfileImage(Request $request, Profile $profile) {
        // Authorizing the user
        if(Gate::denies("change-pic", $profile)) {
            abort(405);
        }

        // Validating 
        $validation = Validator::make($request->all(), []);
        $FileRule = [
            "required",
            FileValidation::types(["jpg", "jpeg", "png"])->max(2048)
        ];

        $validation->sometimes("profile_pic", $FileRule, function() {
            return request()->file("profile_pic");
        });

        $validation->sometimes("cover", $FileRule, function() {
            return request()->file("cover");
        });

        if($validation->fails()) {
            return $this->response("failed", "There is some problem");
        }

        // File Uploading logic
        $cover = $request->file("cover");
        $profile_pic = $request->file("profile_pic");
        $user = auth()->user();
        if($cover) {
            $fileName = time() . $cover->getClientOriginalName();
            $cover->move("cover", $fileName);
            $old_cover = $user->profile->cover;
            $user->profile()->update([
                "cover" => $fileName,
            ]);
            File::delete("cover/$old_cover");
            return $this->response("success", [ "type" => "cover", "file" => $fileName ]);
        } 
        if($profile_pic) {
            $fileName = time() . $profile_pic->getClientOriginalName();
            $profile_pic->move("profile", $fileName);
            $user->profile()->update([
                "profile_pic" => $fileName,
            ]);
            File::delete("profile/$profile_pic");
            return $this->response("success", [ "type" => "profile_pic", "file" => $fileName ]);
        }

    }
}
