<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use App\Classes\Pagination;

class CourseController extends Controller
{
    public function get(Course $course) {
        $sections = $course->sections;
        if(!count($sections) ) {
            abort(405);
        }
        $introduction = $course
                        ->sections()
                        ?->first()
                        ?->contents()
                        ?->first()
                        ->content ?? "";
        $reviews = json_decode($course?->reviews->reviews ?? "");
        if($reviews)
            $reviews = (new Pagination($reviews, request()))->manualPaginate();
        return view("user.courses.course", compact("sections", "course", "reviews", "introduction"));
    }

    public function getCourses() {
        $courses = Course::whereStatus(1)->paginate(6);
        $categories = Category::whereStatus(1)->get();
        return view("guest.courses.courses", compact("courses", "categories"));
    }

    public function getData() {
        $parameters = [];

        // Category Filter
        if(request()->categories) {
            $parameters["categories"] = request()->categories; 
        }

        // Price Filter
        if(request()->price_range) {
            $parameters["price_range"] = request()->price_range;
        }

        // Search Filter 
        if(request()->search) {
            $parameters["search"] = json_decode(request()->search);
        }

        $courses = Course::with("author", "reviews")->filter($parameters)->whereStatus(1)->paginate(6);
        $courses->map(function($course) {
            $stripe_id = $course->stripe_id;
            $is_purchased = auth()->user()->purchases()->where("purchase_product_id", $stripe_id)->exists();
            $course["is_purchased"] = $is_purchased;
        });
        return $courses;
    }

}
