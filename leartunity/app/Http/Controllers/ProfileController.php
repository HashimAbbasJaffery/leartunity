<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImageUploadingRequest;
use App\Models\Course;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\File as FileValidation;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class ProfileController extends Controller
{
    protected $courses;
    public function __construct() {
        $this->courses = Course::with("author", "purchases")->where("author_id", request()->id);
    }
    public function index(Request $request) {

        $courses = $this->courses->paginate(6);
        if(request()->wantsJson()) return $courses;
        $user = auth()->user();
        $profile = Profile::with("user.follows")->where("user_id", $request->id)->first();

        if(!$profile) {
            auth()->user()->profile()->create([
                "follows" => 0
            ]);
        }

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

        $is_following = $user?->follows_to()->where("follower_id", $user->id)->exists();
        $followersCount = $profile->user->follows->count();
        return Inertia::render("User/Profile", [
            "count" => $count,
            "avgRating" => $avgRating,
            "profile" => $profile,
            "courses" => $courses,
            "is_following" => $is_following,
            "followersCount" => $followersCount
        ]);
    }
    public function changeProfileImage(ImageUploadingRequest $request, Profile $profile) {
        $data = $request->get("profile_pic");
        $is_cover = false;
        if($request->get("cover")) {
            $data = $request->get("cover");
            $is_cover = true;
        }
        list(, $data)      = explode(',', $data);
        $data = base64_decode($data);

        // Authorizing the user
        if(Gate::denies("change-pic", $profile)) {
            abort(405);
        }

        $folder = "profile";
        $column = "profile_pic";
        if($is_cover) {
            $folder = "cover";
            $column = "cover";
        }
        $image_name = time() . ".png";
        $path = public_path() . "/$folder/" . $image_name;

        File::delete(public_path(). "/$folder/" . auth()->user()?->profile?->$column);
        File::put($path, $data);

        auth()->user()->profile()->update([
            $column => $image_name
        ]);

        return $this->response("success", [$column, $image_name]);
    }
}
