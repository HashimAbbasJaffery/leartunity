<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Http\Requests\CourseRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Course;
use App\Models\Category;
use Illuminate\Support\Facades\File;
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
        $courses = Course::withoutGlobalScopes()->where("author_id", auth()->user()->id)->paginate(6);
        
        $courses->withPath("/get/courses/" . "1");
        
        return view("Teaching.index", compact("courses"));
    }
    public function destroy(Course $course) {
        
        $this->middleware("is_course_owner:$course->slug");
        $course->delete();
        return redirect()->back();
    }
    public function update(Request $request, Course $course) {
        $this->middleware("is_course_owner:$course->slug");
        $categories = explode(",", $request->categories);
        $slug = str($request->title)->slug("-");
        $file = $request->base64;
        
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

            
            $data = $request->get("base64");
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

        

        return redirect()->to("/instructor");
    }
    public function edit(Request $request, Course $course) {
        $course["categories_id"] = $course->categories->pluck("id")->toArray();
        $categories = Category::all();
        return view("Teaching.edit", compact("categories", "course"));
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

        
        // $fileName = time() . $file->getClientOriginalName();
        // $file->move(public_path("course"), $fileName);

        
        $data = $request->get("base64");
        list(, $data)      = explode(',', $data);
        $data = base64_decode($data);
        $fileName = time() . ".png";
        
        File::put(public_path("course/$fileName"), $data);
       
        $course = Course::create([
            "title" => $request->title,
            "description" => $request->description, 
            "pre_req" => $request->pre_req,
            "price" => $request->price,
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
        return view("Teaching.create", compact("categories"));
    }
}
