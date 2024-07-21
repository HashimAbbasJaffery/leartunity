<?php

namespace App\Http\Controllers;

use App\Interfaces\TrackingService;
use App\Models\Certificate;
use App\Models\Content;
use App\Models\Section;
use App\Services\Quiz;
use Hamcrest\Type\IsBoolean;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function __construct( 
        protected TrackingService $service,
        protected Certificate $certificate
    ) {}
    public function create() {
        return view("Teaching.quiz.create");   
    }
    public function store(Request $request, Section $section) {
        $data = $request->all();

        $questions = (new Quiz)->prepare($data);
        $title = $request->get("title");
        $min_score = $request->get("min-score");
        $questions["min-score"] = $min_score;


        $section->contents()->create([
            "title" => $title ?? "The title",
            "status" => 1,
            "content" => json_encode($questions),
            "duration" => 0,
            "is_paid" => 1,
            "description" => "",
            "sequence" => $section->contents()->count() + 1,
            "content_type" => 2,
            "previous_video" => ($section->contents()->latest()->first())?->id ?? null
        ]);

        return to_route("course.show", [ "course_slug_o" => $section->course->slug ]);
       
    }
    public function submit(Request $request, Content $content) {
        $quiz = (new Quiz)->evaluate($content, $request->all());
        
        $course = $content->section->course;
        
        $service = $this->service->track($content, $course);
        [ $progress, $tracking_track ] = $service;

        if($progress >= 100) {
            $this->certificate->generateAndStore($course);
        }

        if($tracking_track === -1) return $progress;

        $course->tracker()->update([
            "tracking" => json_encode($tracking_track),
            "user_id" => auth()->user()->id,
            "progress" => $progress,
            "status" => 1
        ]);

        return back()->with("quiz", $quiz);
    }
}
