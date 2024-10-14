<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Course;

class ReviewController extends Controller
{
    public function store(Request $request, Course $course) {
        $stars = $request->stars;
        $feedback = $request->feedback;
        $reviews = $course?->reviews ?? null;

        $reviews = $reviews?->reviews ?? [];
        $user = User::with("profile")->firstWhere("id", auth()->user()->id);
        $value = [
            "id" => $user->id,
            "name" => $user->name,
            "pic" => $user->profile->profile_pic,
            "status" => true,
            "stars" => $stars,
            "review" => $feedback
        ];

        $value = [
            ...$reviews,
            $value
        ];


        $total_reviews = count($value);
        $average = $stars;
        if($total_reviews >= 1) {
            $current_stars = ($course?->reviews?->stars ?? null);
            $average = (($current_stars * ($total_reviews - 1)) + $stars) / ($total_reviews);
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

    public function update(Request $request, Course $course) {
        $stars = $request->stars;
        $feedback = $request->feedback;
        $reviews = $course?->reviews ?? null;
        $count = count($course->reviews->reviews);

        $reviews = ($reviews?->reviews) ?? [];

        // Get the current user's review
        $user_review = array_filter($reviews, function($review) {
            return $review->id === auth()->user()->id;
        });

        // Get those reviews which does not contain the user who is updated
        $reviews = array_filter($reviews, function($review) {
            return $review->id !== auth()->user()->id;
        });

        $user_star = reset($user_review)->stars;
        $current_average = $course->reviews->stars;

        $average = ((($current_average * $count) - $user_star) + $stars) / $count;


        $user = User::with("profile")->firstWhere("id", auth()->user()->id);
        $value = [
            ...$reviews,
            [
                "id" => $user->id,
                "name" => $user->name,
                "pic" => $user->profile->profile_pic,
                "status" => true,
                "stars" => $stars,
                "review" => $feedback
            ]
        ];


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
