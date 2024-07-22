<?php

namespace App\Http\Controllers;

use App\Interfaces\TrackingService;
use App\Models\Certificate;
use App\Models\Content;
use App\Models\Section;
use App\Services\CourseCertificate;
use App\Services\Quiz;
use Hamcrest\Type\IsBoolean;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function __construct( 
        protected TrackingService $service,
        protected CourseCertificate $certificate
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
        [ $is_passed, $score ] = $quiz;
        if($is_passed) {
            $course = $content->section->course;
            $quiz_tracker = json_decode($course->tracker->quiz_tracker);
            $quiz_tracker = array_filter($quiz_tracker, function($q) use ($content){
                return $q->id === $content->id;
            });
            $service = $this->service->track($content, $course);
            [ $progress, $tracking_track ] = $service;
    
            if($progress >= 100) {
                $this->certificate->generateAndStore($course);
            }
    
            // tracking_track === 1 tells that user is again repeating the quiz, or the video
            
            $quiz_content = [
                [
                    "id" => $content->id,
                    "score" => $score,
                    "answers" => $request->except("_token")
                ]
            ];
           
            $q_tracker = null;
            if(count($quiz_tracker) && $score <= reset($quiz_tracker)->score) {
                $q_tracker = $course->tracker->quiz_tracker;
            } else if(count($quiz_tracker) && $score > reset($quiz_tracker)->score) {
                $old_tracker = array_filter(json_decode($course->tracker->quiz_tracker), function($q) use ($content){
                    return $q->id !== $content->id;
                });
                reset($quiz_tracker)->score = $score;
                reset($quiz_tracker)->answers = $request->except("_token");
                $q_tracker = json_encode([...$quiz_tracker, ...$old_tracker]);
            } else {
                $q_tracker =  json_encode([ ...json_decode($course->tracker->quiz_tracker), ...$quiz_content ]);
            }

            // It will select user's associated tracker, the WHERE clause is written
            // at Course.php relationship method 
            $course->tracker()->update([
                "tracking" => ($tracking_track === -1) ? $course->tracker->tracking : json_encode($tracking_track) ,
                "user_id" => auth()->user()->id,
                "progress" => $progress,
                "status" => 1,
                "quiz_tracker" => $q_tracker
            ]);
            
        }

        return back()->with("quiz", $quiz);
    }
}
