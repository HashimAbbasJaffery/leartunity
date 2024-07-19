<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\Section;
use App\Services\Quiz;
use Hamcrest\Type\IsBoolean;
use Illuminate\Http\Request;

class QuizController extends Controller
{
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
        // dd(json_decode($content->content));

        $correct = 0;
        $questions = json_decode($content->content);
        $answers = $request->all();
        foreach($answers as $key => $answer) {
            if($key === "_token" || $key === "min-score") continue;
            $key_array = explode("_", $key);
            $key = $key_array[0];
            $keys = ((array)$questions)[$key]?->keys ?? false;


            if(((array)$questions)[$key]->isBoolean && ((array)$questions)[$key]->key == $answer) {
                $correct++;
            } else if($keys && $keys[$answer] === "on" && count($key_array) == 1) {
                $correct++;
            } else if(count($key_array) > 1) {
                
            }
        }

        $result_percentage = ($correct / (count((array)$questions) - 1)) * 100;
        if($result_percentage >= ((array)$questions)["min-score"]) {
            return "Passed " . " with $result_percentage% accuracy";
        } else {
            return "Failed, Please Try again. You got $result_percentage% correct";
        }
    }
}
