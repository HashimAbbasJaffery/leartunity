<?php

namespace App\Http\Controllers;

use App\Http\Requests\CourseRequest;
use App\Models\Category;
use App\Models\Course;
use App\Services\FilterService;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use App\Classes\Pagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Stripe\StripeClient as Stripe;
use App\Http\Helpers\Helpers;
use Illuminate\Support\Str;

class CourseController extends Controller
{
    public $i = 0;
    public function __construct(
        Request $request,
        protected Stripe $stripe
    ){}

    public function get(Course $course) {
        $course->description = Str::markdown($course->description, [
            "html_input" => "strip"
        ]);
        $sections = $course->sections;
        if(!count($sections) ) {
            abort(403);
        }
        $introduction = $course
                        ->sections()
                        ?->first()
                        ?->contents()
                        ?->first()
                        ->content ?? "";
        $reviews = $course?->reviews->reviews ?? "";
        if($reviews)
            $reviews = (new Pagination($reviews, request()))->manualPaginate();
        return view("user.courses.course", compact("sections", "course", "reviews", "introduction"));
    }

    public function getCourses() {
        $courses = Course::withSum("contents", "duration")->whereStatus(1)->paginate(6);
        $courses->withPath("get/courses");
        
        $categories = Category::whereHas("courses")->get();
        return view("guest.courses.courses", compact("courses", "categories"));
    }

    public function getData(Request $request, FilterService $service, $status = null) {
        $courses = $service->filter($request, $status);
        return $courses;
    }

    public function ajax() {
        $courses = Course::whereStatus(1)->paginate(6);
        return $courses;
    }
    
}
