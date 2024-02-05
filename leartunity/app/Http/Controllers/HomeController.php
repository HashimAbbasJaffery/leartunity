<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Plan;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Models\Category;

class HomeController extends Controller
{
    public function index() {
        $categories = Category::withCount("courses")
                        ->whereHas("courses")
                        ->orderBy("courses_count", "desc")
                        ->limit(3)
                        ->whereStatus(1)
                        ->get();
        
        
        $plans = Plan::whereStatus(1)->get();
        return view("user.index", compact("categories", "plans"));
    }
}
