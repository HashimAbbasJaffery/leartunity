<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;

class ReviewController extends Controller
{
    public function store(Request $request, Course $course) {
        $stars = $request->stars;
        $feedback = $request->feedback;
        $reviews = $course?->reviews ?? null;

        $reviews = $reviews?->reviews;
        return $reviews;

        $value = [
            [
                "id" => auth()->user()->id,
                "name" => auth()->user()->name,
                "status" => true,
                "stars" => $stars,
                "review" => $feedback
            ]
        ];


        $total_reviews = count($value);
        $average = $stars;
        if($total_reviews >= 1) {
            $current_stars = ($course?->reviews?->stars ?? null);
            $average = (($current_stars * $total_reviews) + $stars) / $total_reviews;
        }
        
        $course->reviews()->updateOrCreate([
            "reviewable_id" => $course->id,
        ], [
            "reviews" => $value,
            "stars" => $average,
            "status" => 1,
        ]);

        return 1;
        
    }
}
