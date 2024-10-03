<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Course;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Inertia\Inertia;

class AdminController extends Controller
{
    public function index() {
        $courses_count = Course::withoutGlobalScopes()->count();
        $categories_count = Category::withoutGlobalScopes()->count();
        $users_count = User::count();

        $counts = [
            "courses" => $courses_count,
            "categories" => $categories_count,
            "users" => $users_count
        ];

        $categories = Category::withoutGlobalScopes()->whereHas("courses")->withCount("courses")->orderBy("courses_count", "DESC")->limit(5)->get();
        $labels = $categories->pluck("category")->toArray();
        $data = $categories->pluck("courses_count")->toArray();

        $pie_chart = [
            "labels" => $labels,
            "data" => $data
        ];

        $courses = Course::withoutGlobalScopes()->whereHas("purchases")->withCount("purchases")->orderBy("purchases_count", "DESC")->limit(10)->get();
        $courses_labels = $courses->pluck("title")->toArray();
        $courses_data = $courses->pluck("purchases_count")->toArray();
        $bar_graph = [
            "labels" => $courses_labels,
            "data" => $courses_data
        ];
        // return view("Admin.index", compact("counts", "pie_chart", "bar_graph"));
        return Inertia::render("Admin/Index", [
            "counts" => $counts,
            "pie_chart" => $pie_chart,
            "bar_graph" => $bar_graph
        ]);
    }
}
