<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\Course;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function create(Course $course, Content $content) {
        $replies_to = request()->get("replies_to");
        $to = request()->get("replying_to");
        $comment = request()->get("comment");
        $course->comments()->create([
            "comment" => $comment,
            "status" => 1,
            "replies_to" => $replies_to,
            "user_id" => auth()->user()->id,
            "content_id" => $content->id,
            "to" => $to,
        ]);

        return 1;
    }
}
