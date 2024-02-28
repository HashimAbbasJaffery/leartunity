<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\Course;
use App\Models\Purchase;
use App\Services\SectionContentService;
use App\Models\Section;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;

class LearningController extends Controller
{
    public $sectionService;
    public function __construct(SectionContentService $sectionService) {
        $this->sectionService = $sectionService;
    }

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
        abort_if(!$does_own_course, 403); 
        $next_content = $this->sectionService->next_content($content);
        $tracker = Arr::pluck(json_decode($course->tracker->tracking), "id");
        return view("Learning.course", compact("course", "comments", "current_content", "next_content", "tracker"));
    }
}
