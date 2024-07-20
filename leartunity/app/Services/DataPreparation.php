<?php 

namespace App\Services;

class DataPreparation {
    public function prepareForQuiz($answers) {
        $groupedArray = [];
        foreach ($answers as $key => $value) {
            if($key === "_token" || $key === "min-score") continue;
            $prefix = explode("_", $key)[0];
            if (strpos($key, $prefix) === 0 && isset((explode("_", $key)[1]))) {
                $questionNumber = explode("_", $key)[1]; // Extract the question number
                $groupedArray[$prefix][$questionNumber] = $value;  // Add value to nested array
            } else {
                $groupedArray[$key] = [$value]; // Keep non-matching key-value pair
            }
        }
        return $groupedArray;
    }
}