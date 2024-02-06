<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use App\Classes\Pagination;

class CourseController extends Controller
{
    public function get(Course $course) {
        $sections = $course->sections;
        if(!count($sections) ) {
            abort(405);
        }
        $introduction = $course
                        ->sections()
                        ?->first()
                        ?->contents()
                        ?->first()
                        ->content ?? "";
        $reviews = json_decode($course?->reviews->reviews ?? "");
        if($reviews)
            $reviews = (new Pagination($reviews, request()))->manualPaginate();
        return view("user.courses.course", compact("sections", "course", "reviews", "introduction"));
    }
}
