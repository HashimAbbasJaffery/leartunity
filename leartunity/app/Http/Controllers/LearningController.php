<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\Content;
use App\Models\Course;
use App\Models\Purchase;
use App\Services\SectionContentService;
use App\Models\Section;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LearningController extends Controller
{
    public $sectionService;
    public function __construct(SectionContentService $sectionService) {
        $this->sectionService = $sectionService;
    }

    public function index() {
        $user = auth()->user();
        $purchases = $user->purchases;

        $certificates = Certificate::whereIn("certificate_id", $purchases->pluck("course.id")->toArray())
                                    ->where("user_id", auth()->id())
                                    ->get();

        $purchases = $purchases->map(function($purchase) use($certificates) {
            $purchase["certificate"] = $certificates->firstWhere("certificate_id", $purchase->course->id);
            return $purchase;
        });

        return Inertia::render("OwnedCourses/Learning", [
            "purchases" => $purchases
        ]);
    }
    public function get(Course $course, Content $content) {
        $current_content = $content;
        $stripe_id = $course->stripe_id;
        $does_own_course = auth()
                            ->user()
                            ->purchases()
                            ->where("purchase_product_id", $stripe_id)
                            ->exists();

        $comments = $course->comments()->where("content_id", $content->id)->whereNull("replies_to")->get();
        abort_if(!$does_own_course, 403);
        $next_content = $this->sectionService->next_content($content);

        $instance_tracker = json_decode($content->section->course->tracker->tracking);
        $quiz_tracker = json_decode($content->section->course->tracker->quiz_tracker);

        $instance_tracker = array_filter($instance_tracker, function($track) use($content) {
            return $track->id == $content->id;
        });
        $quiz_tracker = array_filter($quiz_tracker, function($track) use($content) {
            return $track->id == $content->id;
        });

        $instance_tracker = !count($instance_tracker) ? $instance_tracker : reset($instance_tracker);
        $quiz_tracker = !count($quiz_tracker) ? $quiz_tracker : reset($quiz_tracker);

        $tracker = Arr::pluck(json_decode($course->tracker->tracking), "id");

        if(!$next_content) {
            $next_section = $content->section->next()->firstWhere("course_id", $course->id);
            $next_content = $next_section->contents()->first();
        }

        $certificate = Certificate::where("user_id", auth()->id())->where("certificate_id", $course->id)->first();
        return Inertia::render("Learning/Course", [
            "course" => $course,
            "comments" => $comments,
            "current_content" => $current_content,
            "next_content" => $next_content,
            "tracker" => $tracker,
            "instance_tracker" => $instance_tracker,
            "quiz_tracker" => $quiz_tracker,
            "certificate_id" => $certificate?->certificate_id ?? null
        ]);
    }
}
