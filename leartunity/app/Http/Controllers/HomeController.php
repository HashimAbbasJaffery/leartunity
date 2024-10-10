<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Plan;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Quote;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index() {
        $quote = Quote::all()->random(1)->where("status", 1)->first();
        $categories = Category::withCount("courses")
                        ->whereHas("courses")
                        ->with(["courses" => function($query) {
                            $query->limit(24);
                        }, "courses.author", "courses.purchases"])
                        ->limit(3)
                        ->whereStatus(1)
                        ->orderBy("courses_count", "desc")
                        ->get();
        // dd($categories);

        $plans = Plan::whereStatus(1)->get();
        return Inertia::render("Index", [
            "categories" => $categories,
            "plans" => $plans,
            "quote" => $quote
        ]);
    }
}
