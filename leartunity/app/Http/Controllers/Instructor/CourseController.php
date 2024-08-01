<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Http\Requests\CourseRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Course;
use App\Models\Category;
use Illuminate\Support\Facades\File;
use Inertia\Inertia;
use Stripe\StripeClient as Stripe;

class CourseController extends Controller
{
    public function __construct(
        Request $request,
        protected Stripe $stripe
    ){
        $slug = "";
        try {
            $course = $request->route()->parameters()["course"];
            $slug = ($course->slug) ? $course->slug : $course;
        } catch(\Exception $e) {

        }

        Log::debug($slug);
        if($slug)
            $this->middleware("is_course_owner:$slug");
    }
    public function index() {
        $courses = Course::withoutGlobalScopes()->where("author_id", auth()->user()->id)->get();


        return Inertia::render("Instructor/index", [
            "courses" => $courses
        ]);
    }
    public function destroy(Course $course) {

        $this->middleware("is_course_owner:$course->slug");
        $course->delete();
        return redirect()->back();
    }
    public function update(Request $request, Course $course) {
        $this->middleware("is_course_owner:$course->slug");
        $validated = $request->validate([
            "title" => ["required", "min:4", "max:50"],
            "description" => ["required", "min:25", "max:1000"],
            "pre_req" => ["required", "min:25", "max:1000"],
            "price" => ["required"],
            "categories" => ["required"]
        ]);
        $categories = $request->categories;
        $slug = str($request->title)->slug("-");
        $file = $request->image;

        $stripe = $this->stripe->products->retrieve($course->stripe_product_id);


        $stripe = $this->stripe->products->create([
            'name' => $request->title,
            'default_price_data' => [
                "currency" => "usd",
                "unit_amount" => dollarsToCents($request->price)
            ]
        ]);
        $product = $this->stripe->products->retrieve($course->stripe_product_id);
        $product->name = $request->title;
        $product->default_price_data["unit_amount"] = $request->price;
        $product->save();

        $fileName = $course->thumbnail;
        if($file) {
            $data = $request->get("image");
            list(, $data) = explode(',', $data);
            $data = base64_decode($data);
            $fileName = time() . ".png";

            File::put(public_path("course/$fileName"), $data);

            // $fileName = time() . $file->getClientOriginalName();
            // $file->move(public_path("course"), $fileName);
        }

        $course->update([
            "title" => $request->title,
            "description" => $request->description,
            "pre_req" => $request->pre_req,
            "price" => $request->price,
            "thumbnail" => $fileName,
            "author_id" => auth()->id(),
            "status" => 0,
            "slug" => $slug,
            "stripe_id" => $stripe->default_price,
        ]);


        $course->categories()->sync($categories);
        $courses = Course::all();
        return redirect()->to("/courses")->with(compact("courses"));
    }
    public function edit(Request $request, Course $course) {
        $categories = Category::all();
        return Inertia::render("Courses/Edit", [
            "categories" => $categories,
            "course" => $course
        ]);
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

        $product_id = $stripe->id;

        $data = $request->get("base64");
        list(, $data)      = explode(',', $data);
        $data = base64_decode($data);
        $fileName = time() . ".png";

        File::put(public_path("course/$fileName"), $data);

        $user_preferred_currency = User::find(auth()->id())->currency->currency;
        $exchange_rate = \App\Helpers\exchange_rate($user_preferred_currency);

        $course = Course::create([
            "title" => $request->title,
            "description" => $request->description,
            "pre_req" => $request->pre_req,
            "price" => $request->price / $exchange_rate,
            "thumbnail" => $fileName,
            "author_id" => auth()->id(),
            "status" => 0,
            "slug" => $slug,
            "stripe_id" => $stripe->default_price,
            "stripe_product_id" => $product_id
        ]);
        $course->categories()->attach($categories);

        return redirect()->to("/instructor");
    }
    public function show(Request $request, Course $course) {
        $sections = $course->sections;
        return view("Teaching.show", compact("course", "sections"));
    }

    public function changeStatus(Request $request, Course $course) {

        $this->middleware("is_course_owner:$course->slug");
        $course->update([
            "status" => !$course->status
        ]);

        return 1;
    }
    public function create() {
        $categories = Category::all();
        return Inertia::render("Courses/Add", [
            "categories" => $categories
        ]);
    }
}
