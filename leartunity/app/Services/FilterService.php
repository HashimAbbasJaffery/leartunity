<?php

namespace App\Services;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Course;

class FilterService {
    public function filter(Request $request, $status = null) {
        $parameters = [];

        // Category Filter
        if(request()->categories) {
            $parameters["categories"] = request()->categories;
        }


        $user_currency = (User::find(auth()->id()))->currency;
        // Price Filter
        if(request()->price_range) {
            $parameters["price_range"] = request()->price_range;
        }

        if(isset($parameters["price_range"])) {
            $parameters["price_range"][0] /= \App\Helpers\exchange_rate($user_currency->currency);
            $parameters["price_range"][1] /= \App\Helpers\exchange_rate($user_currency->currency);
        }

        // Search Filter
        if(request()->search) {
            $parameters["search"] = json_decode(request()->search);
        }

        if(!$status) {
            $courses = Course::with("author.profile", "author", "reviews")->filter($parameters)->paginate(6);
        } else {
            $courses = Course::with("author.profile", "author", "reviews")->whereStatus($status)->filter($parameters)->paginate(6);
        }
        $courses->map(function($course) {
            $stripe_id = $course->stripe_id;
            $is_purchased = auth()->user()?->purchases()->where("purchase_product_id", $stripe_id)->exists();
            $course["is_purchased"] = $is_purchased;
        });
        return $courses;
    }
}
