<?php

use Illuminate\Pagination\LengthAwarePaginator as Paginator;

if (!function_exists('pagination')) {

    /**
     * description
     *
     * @param
     * @return
     */
   
    function pagination($array, $options)
    {
        $total = count($array);
        $per_page = $options["per_page"];
        $current_page = $options["current_page"] ?? 1;
        $starting_point = ($current_page * $per_page) - $per_page;
        $array = array_slice($array, $starting_point, $per_page, true);
        $reviews = new Paginator($array, $total, $per_page, $current_page, [
            'path' => $options["path"],
            'query' => $options["query"]
        ]);

        return $reviews;
    }
}

if(!function_exists("message")) {
    function message($status, $message) {
        return [
            "status" => $status,
            "message" => $message 
        ];
    }
}

if(!function_exists("eligibleForReview")) {
    function eligibleForReview() {
        $user = auth()->user();

        // Is user loggedin? 

        if(!$user) return message(false, "Login to post your review!");
        
        // If everything goes perfectly 

        return message(true, "");

    } 
}

if(!function_exists("calculateReviewStars")) {
    function calculateReviewStars($rating) {
        $markup = "";
        $total = 5;
        $stars = floor($rating); // 1
        $halfStar = $rating - $stars; // 1.4 - 1 = 0.4
        $remainingStars = ($total - $stars);
        if($halfStar >= 0.5) {
            $remainingStars -= $halfStar;
        }
        $remainingStars = floor($remainingStars);


        if($rating <= 5 && $rating != 0) {
            for($i = 0; $i < $stars; $i++) {
                $markup .= '<i class="fa-solid fa-star"></i>';
            }
            if($halfStar >= 0.5) {  
                $markup .= '<i class="fa-solid fa-star-half-stroke"></i>';
            }
            for($i = 0; $i < ($remainingStars); $i++) {
                $markup .= '<i class="fa-regular fa-star"></i>';
            }
        } else { 
            $markup .= '<p>No rating yet!</p>';
        }

        return $markup;
    }
}

if(!function_exists("secondToMinutes")) {
    function secondToMinutes($seconds) {
        // Calculate minutes and remaining seconds
        $minutes = floor($seconds / 60);
        $remainingSeconds = $seconds % 60;

        // Format the time as MM:SS
        $formattedTime = sprintf('%02d:%02d', $minutes, $remainingSeconds);

        return $formattedTime;

    }
}

if(!function_exists("dollarsToCents")) {
    function dollarsToCents($dollars) {
        // Remove any non-numeric characters from the input
        $dollars = preg_replace("/[^0-9.]/", "", $dollars);
        
        // Convert dollars to cents
        $cents = round(floatval($dollars) * 100);
        
        return $cents;
    }
}

if(!function_exists("secondsToHours")) {
        function secondsToHours($seconds) {
            // Calculate hours
            $hours = floor($seconds / 3600);
    
            // Calculate remaining minutes
            $minutes = floor(($seconds % 3600) / 60);
            
            // Calculate remaining seconds
            $remainingSeconds = $seconds % 60;
            
            // Format the result
            $result = sprintf('%02d:%02d:%02d', $hours, $minutes, $remainingSeconds);
            
            return $result;
        }
        
}