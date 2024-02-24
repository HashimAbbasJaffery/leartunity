<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class LearningController extends Controller
{
    public function index() {
        $user = auth()->user();
        $purchases = $user->purchases;
        return view("Learning.index", compact("purchases"));
    }
    public function get(Course $course) {
        $stripe_id = $course->stripe_id;
        $does_own_course = auth()
                            ->user()
                            ->purchases()
                            ->where("purchase_product_id", $stripe_id)
                            ->exists();
        $comments = $course->comments()->whereNull("replies_to")->get();
        abort_if(!$does_own_course, 403); 
        return view("Learning.course", compact("course", "comments"));
    }
}
