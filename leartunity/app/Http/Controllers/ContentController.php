<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\Course;
use App\Models\Section;
use Illuminate\Http\Request;

class ContentController extends Controller
{
    protected function getContentDetails(Content $content) {
        if(!$content) return $this->response("error", "Content does not exist");
        $section = $content->belongsTo(Section::class, "contentable_id")->first();
        if(!$section) return $this->response("error", "Section Does not exist");
        $course = $section->course;
        return $course;
    }
    protected function checkContentEligibility(Content $content, $successResponse) {
        $course = $this->getContentDetails($content);
        if($course["type"] === "error") return $this->response("error", "something went wrong");
        $isEligible = auth()->user()->purchases()->where("purchase_product_id", $course->stripe_id)->exists();
        if(!$content->status) return $this->response("error", "This Content is archived");
        if(!$isEligible && ($content->is_paid)) return $this->response("error", "You are not eligible to access");

        return $this->response("success", $successResponse);
    }
    public function get(Content $content) {
        
        $course = Course::find(request()->get("course_id"));
        $video = $content->content;
        
        $content = $this->checkContentEligibility($content, $video);
        
        return $content;
    
    }
}
