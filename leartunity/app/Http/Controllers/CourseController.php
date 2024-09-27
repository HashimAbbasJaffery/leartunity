<?php

namespace App\Http\Controllers;

use App\Http\Requests\CourseRequest;
use App\Models\Category;
use App\Models\Course;
use App\Models\User;
use App\Services\FilterService;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use App\Classes\Pagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;
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
        $currency = User::find(auth()->id())?->currency;

        if($currency)
            $course->price *= round(\App\Helpers\exchange_rate($currency->currency), 2);

        $course->currency = $currency?->unit ?? "$";
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
        $courses_count = $course->author->courses->count();;
        return Inertia::render("Courses/Course", [
            "sections" => $sections,
            "course" => $course,
            "reviews" => $reviews,
            "courses_count" => $courses_count,
            "introduction" => $introduction
        ]);
    }

    public function getCourses() {
        $filters = [
            "categories" => request()->get("categoryList") ?? "",
            "price_range" => [request()->get("from") ?? 1, request()->get("to") ?? PHP_INT_MAX],
            "type" => request()->get("type") ?? "",
            "search" => request()->get("search") ?? ""
        ];
        $courses = Course::withSum("contents", "duration")
                            ->with("author", "purchases")
                            ->filter($filters)
                            ->whereStatus(1)
                            ->paginate(6);
        if(request()->wantsJson()) return $courses;
        $categories = Category::withCount("courses")
                                ->orderBy("courses_count", "ASC")
                                ->whereHas("courses")
                                ->limit(10)
                                ->get();
        return Inertia::render("Courses/Courses", [
            "categories" => $categories,
            "courses" => $courses
        ]);
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
