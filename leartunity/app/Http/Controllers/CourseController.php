<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use App\Http\Helpers\Helpers;

class CourseController extends Controller
{
    public function get(Course $course) {
        $sections = $course->sections;
        $reviews = json_decode($course->reviews->reviews);
        $total = count($reviews);
        $per_page = 1;
        $current_page = request()->page ?? 1;
        $starting_point = ($current_page * $per_page) - $per_page;
        $array = array_slice($reviews, $starting_point, $per_page, true);
        $reviews = new Paginator($array, $total, $per_page, $current_page, [
            'path' => request()->url(),
            'query' => request()->query()
        ]);
        return view("user.courses.course", compact("sections", "course", "reviews"));
    }
}
