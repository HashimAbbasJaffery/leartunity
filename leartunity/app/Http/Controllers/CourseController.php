<?php

namespace App\Http\Controllers;

use App\Http\Requests\CourseRequest;
use App\Models\Category;
use App\Models\Course;
use App\Services\FilterService;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use App\Classes\Pagination;
use Illuminate\Support\Facades\Http;
use Stripe\StripeClient as Stripe;
use App\Http\Helpers\Helpers;
use Illuminate\Support\Str;

class CourseController extends Controller
{
    public $i = 0;
    public function __construct(
        protected Stripe $stripe
    ){}
    public function index() {
        $courses = Course::where("author_id", auth()->user()->id)->paginate(6);
        
        $courses->withPath("/get/courses/" . "1");
        
        return view("Teaching.index", compact("courses"));
    }
    public function get(Course $course) {
        $course->description = Str::markdown($course->description, [
            "html_input" => "strip"
        ]);
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
        $courses->withPath("get/courses");
        // $courses = Http::get("ajaxCourses");
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
    public function create() {
        $categories = Category::all();
        return view("Teaching.create", compact("categories"));
    }
    public function store(CourseRequest $request) {
        $categories = explode(",", $request->categories);
        $slug = str($request->title)->slug("-");
        $file = $request->file("thumbnail");
        
        $stripe = $this->stripe->products->create([
            'name' => $request->title,
            'default_price_data' => [
                "currency" => "usd",
                "unit_amount" => dollarsToCents($request->price)
            ]
        ]);

        $course = Course::create([
            "title" => $request->title,
            "description" => $request->description, 
            "pre_req" => $request->pre_req,
            "price" => $request->price,
            "thumbnail" => "",
            "author_id" => auth()->id(),
            "status" => 0,
            "slug" => $slug,
            "stripe_id" => $stripe->default_price
        ]);
        $course->categories()->attach($categories);
        $fileName = time() . $file->getClientOriginalName();
        $file->move(public_path("course"), $fileName);

        return redirect()->to("/instructor");
    }
    public function show(Course $course) {
        $sections = $course->sections;
        return view("Teaching.show", compact("course", "sections"));
    }
    public function changeStatus(Request $request, Course $course) {
        $course->update([
            "status" => !$course->status
        ]);

        return 1;
    }

}
