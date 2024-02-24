<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function create(Course $course) {
        $course->comments()->create([
            "comment" => request()->get("comment"),
            "status" => 1,
            "user_id" => auth()->user()->id,
        ]);

        return 1;
    }
}
