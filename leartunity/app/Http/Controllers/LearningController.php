<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\Course;
use Illuminate\Http\Request;

class LearningController extends Controller
{
    public function index() {
        $user = auth()->user();
        $purchases = $user->purchases;
        return view("Learning.index", compact("purchases"));
    }
    public function get(Course $course, Content $content) {
        $current_content = $content;
        $stripe_id = $course->stripe_id;
        $does_own_course = auth()
                            ->user()
                            ->purchases()
                            ->where("purchase_product_id", $stripe_id)
                            ->exists();
        $comments = $course->comments()->where("content_id", $content->id)->whereNull("replies_to")->get();
        $next_content = $course->contents()->where("sequence", $content->sequence + 1)->first();
        abort_if(!$does_own_course, 403); 
        return view("Learning.course", compact("course", "comments", "current_content", "next_content"));
    }
}
