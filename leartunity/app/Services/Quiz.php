<?php 

namespace App\Services;
use App\Models\Content;

class Quiz {
    protected $correct;
    public function __construct() {
        $this->correct = 0;
    }
    public function prepare(array $data): array {
        $array = [];

        $pattern = '/^(question|boolean)/';

        $filteredData = array_filter($data, function($key) use ($pattern) {
            return preg_match($pattern, $key);
        }, ARRAY_FILTER_USE_KEY);
        
        foreach($filteredData as $key => $datum) {
            // pre-processing the question's name and its associated ID
            $id = explode("-", $key)[1]; 
            $array["question-$id"]["question"] = $datum;

            // Creating List of options and inserting them into the array, and putting its key 
            // or putting the key 0/1 if question is type of boolean
            for($i = 1; $i <= 4; $i++) {
                if(str_contains($key, "question")) {
                    $array["question-$id"]["options"][] = $data["q-answer-$i-$id"];
                    $array["question-$id"]["keys"][] = $data["q-key-$i-$id"] ?? "";
                    $array["question-$id"]["isBoolean"] = false;
                } else if(str_contains($key, "boolean")){
                    $array["question-$id"]["isBoolean"] = true;
                    $array["question-$id"]["key"] = isset($data["b-key-1-$id"]) ? 1 : 0;
                }
            }

        }
        return $array;
    }
    protected function marking($answers, $answer, $key, $keys) {
        if(is_int($keys) && $keys == $answer[0]) {
            $this->correct++;
        } else if(!is_int($keys)) {
            $is_correct = true;
            foreach($answers[$key] as $answer) {
                if(!array_key_exists($answer, $keys)) {
                    $is_correct = false;
                }
                if(count($answers[$key]) !== count($keys)) {
                    $is_correct = false;
                }
            }
            if($is_correct) {
                $this->correct++;
            }

        }
    }
    public function evaluate(Content $content, $answers): array {
        $correct = 0;
        $questions = json_decode($content->content);
       
        $answers = (new DataPreparation)->prepareForQuiz($answers);

        foreach($answers as $key => $answer) {
            if($key === "_token" || $key === "min-score") continue;

            $keys = ((array)$questions)[$key]?->keys ?? ((array)$questions)[$key]?->key;

            if(!is_int($keys)) {
                $keys = array_filter($keys, function($key) {
                    return $key === "on";
                });
            } 

            // Marking the score
            $this->marking($answers, $answer, $key, $keys);
        }


        $result_percentage = ($this->correct / (count((array)$questions) - 1)) * 100;
        if($result_percentage >= ((array)$questions)["min-score"]) {
            return [ 1, $result_percentage ];
        } else {
            return [ 0, $result_percentage ];
        }
    }
}