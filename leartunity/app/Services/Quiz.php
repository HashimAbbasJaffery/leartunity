<?php 

namespace App\Services;

class Quiz {
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
}