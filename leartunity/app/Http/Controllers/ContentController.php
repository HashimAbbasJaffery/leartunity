<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContentRequest;
use App\Http\Requests\ContentUpdateRequest;
use App\Interfaces\LinkedList;
use App\Models\Content;
use App\Models\Course;
use App\Models\Section;
use App\Services\ContentDescription;
use App\Services\ResumableJS;
use App\Services\VideoDescription;
use FFMpeg\FFProbe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Inertia\Inertia;


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
    public function store(ContentRequest $request, Section $section, LinkedList $list, ResumableJS $jws, VideoDescription $videoService) {
        $title = $request->title;
        $description = $request->description;
        $new_content_id = null;


        // It is using resumableJS behind the scene
        $progress = $jws->upload($request, function($fileName) use($section, $title, $description, $list, $videoService) {

            $count = $section->contents->count();
            $previous_content = $list->get_last($section);
            $duration = $videoService->getDuration($fileName);;

            $new_content = $section->contents()->create([
                "title" => $title,
                "status" => 1,
                "content" => $fileName,
                "duration" => $duration,
                "is_paid" => 1,
                "sequence" => $count +  1,
                "description" => $description,
                "previous_video" => $previous_content?->id,
            ]);

            // Creating the thumbnail of the video and storing it into the database
            $thumbnail_path = (new ContentDescription())->thumbnail(public_path("uploads/$fileName"));
            $new_content->thumbnail = $thumbnail_path;
            $new_content->save();

            $previous_content?->update([
                "next_video" => $new_content->id
            ]);

        });;

        return $section->latest_content();

    }
    public function update(ContentUpdateRequest $request, Content $content, LinkedList $list, ResumableJS $jws) {
        $title = $request->title;
        $description = $request->description;

        $progress = $jws->upload($request, function($fileName) use($content, $title, $description) {
            File::delete(public_path("uploads/" . $content->content));

            $thumbnail_path = (new ContentDescription())->thumbnail(public_path("uploads/$fileName"));
            $content = $content->update([
                "title" => $title,
                "description"=> $description,
                "content" => $fileName,
                "thumbnail" => $thumbnail_path
            ]);

        }, function() use($content, $title, $description) {
            $content->update([
                "title"=> $title,
                "description"=> $description
            ]);
        });

        $content = $content->refresh();
        $content->progress = 0;
        return $content;

    }
    public function destroy(Content $content, LinkedList $list) {
        $section = $content->section;
        $list->remove($content);
        $section->refresh();
        return $section->contents;
    }

    public function deleteMultiple(Request $request) {
        return $request->all();
    }
}
