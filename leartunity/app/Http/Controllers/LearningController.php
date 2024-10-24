<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\Content;
use App\Models\Course;
use App\Models\Purchase;
use App\Services\ContentService;
use App\Services\SectionContentService;
use App\Models\Section;
use App\Services\VideoTrackingService;
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
            $purchase->load("course", "course.author", "course.tracker", "course.contents", "course.reviews");
            return $purchase;
        });

        return Inertia::render("OwnedCourses/Learning", [
            "purchases" => $purchases
        ]);
    }
    public function get(Course $course, Content $content, ContentService $contentService) {
        $course->load(["author", "sections", "tracker"]);
        $current_content = $content;
        $comments = $course->comments()
                            ->where("content_id", $content->id)
                            ->whereNull("replies_to")
                            ->paginate(2)
                            ->withQueryString();
        if(request()->expectsJson()) return $comments;

        $is_purchased = $course->purchases()->where("user_id", auth()->id())->exists();

        $next_content = $contentService->getNextContent($content);

        $certificate = Certificate::where("user_id", auth()->id())->where("certificate_id", $course->id)->first();
        return Inertia::render("Learning/Course", [
            "course" => $course,
            "comments" => $comments,
            "current_content" => $current_content,
            "next_content" => $next_content,
            "certificate_id" => $certificate?->certificate_id ?? null,
            "is_purchased" => $is_purchased
        ]);
    }
}
