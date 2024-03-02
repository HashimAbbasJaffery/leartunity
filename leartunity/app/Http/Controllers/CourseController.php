<?php

namespace App\Http\Controllers;

use App\Http\Requests\CourseRequest;
use App\Models\Category;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use App\Classes\Pagination;
use Illuminate\Support\Facades\Http;
use Stripe\StripeClient as Stripe;
use App\Http\Helpers\Helpers;

class CourseController extends Controller
{
    public $i = 0;
    public function __construct(
        protected Stripe $stripe
    ){}
    public function index() {
        $courses = Course::where("author_id", auth()->user()->id)->paginate(6);
        $courses->withPath("get/courses");
        
        return view("Teaching.index", compact("courses"));
    }
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
        $courses->withPath("get/courses");
        // $courses = Http::get("ajaxCourses");
        $categories = Category::whereHas("courses")->get();
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

        $courses = Course::with("author.profile", "author", "reviews")->filter($parameters)->whereStatus(1)->paginate(6);
        $courses->map(function($course) {
            $stripe_id = $course->stripe_id;
            $is_purchased = auth()->user()?->purchases()->where("purchase_product_id", $stripe_id)->exists();
            $course["is_purchased"] = $is_purchased;
        });
        return $courses;
    }

    public function ajax() {
        $courses = Course::whereStatus(1)->paginate(6);
        return $courses;
    }
    public function create() {
        return view("Teaching.create");
    }
    public function store(CourseRequest $request) {
        $slug = str($request->title)->slug("-");
        $file = $request->file("thumbnail");
        
        $stripe = $this->stripe->products->create([
            'name' => $request->title,
            'default_price_data' => [
                "currency" => "usd",
                "unit_amount" => dollarsToCents($request->price)
            ]
        ]);

        Course::create([
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
        $fileName = time() . $file->getClientOriginalName();
        $file->move(public_path("course"), $fileName);

        return redirect()->to("/instructor");
    }
    public function show(Course $course) {
        $sections = $course->sections;
        return view("Teaching.show", compact("course", "sections"));
    }

}
