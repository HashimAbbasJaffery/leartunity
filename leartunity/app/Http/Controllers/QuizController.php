<?php

namespace App\Http\Controllers;

use App\Services\Quiz;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function create() {
        return view("Teaching.quiz.create");   
    }
    public function store(Request $request) {
        $data = $request->all();
        $questions = (new Quiz)->prepare($data);
        dd($questions);
    }
}
