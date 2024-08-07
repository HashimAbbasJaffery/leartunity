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

        $instance_tracker = json_decode($content->section->course->tracker->tracking);
        $quiz_tracker = json_decode($content->section->course->tracker->quiz_tracker);

        $instance_tracker = array_filter($instance_tracker, function($track) use($content) {
            return $track->id == $content->id;
        });
        $quiz_tracker = array_filter($quiz_tracker, function($track) use($content) {
            return $track->id == $content->id;
        });
        
        $instance_tracker = !count($instance_tracker) ? $instance_tracker : reset($instance_tracker);
        $quiz_tracker = !count($quiz_tracker) ? $quiz_tracker : reset($quiz_tracker);
        
        $tracker = Arr::pluck(json_decode($course->tracker->tracking), "id");
        return view("Learning.course", compact("course", "comments", "current_content", "next_content", "tracker", "instance_tracker", "quiz_tracker"));
    }
}
