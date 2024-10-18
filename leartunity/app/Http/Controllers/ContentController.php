<?php

namespace App\Http\Controllers;

use App\Classes\Video;
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
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Inertia\Inertia;


class ContentController extends Controller
{

    public function store(ContentRequest $request, Section $section, LinkedList $list, ResumableJS $jws, Video $video) {
        $this->authorize("create", $section->course);
        $title = $request->title;
        $description = $request->description;


        // It is using resumableJS behind the scene
        $jws->upload($request, function($fileName) use($section, $title, $description, $list, $video) {

            $count = $section->contents->count();
            $previous_content = $list->get_last($section);
            $duration = $video->length(storage_path("app/videos/$fileName"));

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
            $thumbnail_path = $video->snapshot(storage_path("app/videos/$fileName"));
            $new_content->thumbnail = $thumbnail_path;
            $new_content->save();

            $previous_content?->update([
                "next_video" => $new_content->id
            ]);

        });;

        return $section->latest_content();

    }
    public function update(ContentUpdateRequest $request, Content $content, LinkedList $list, ResumableJS $jws, Video $video) {
        $title = $request->title;
        $description = $request->description;

        $progress = $jws->upload($request, function($fileName) use($content, $title, $description, $video) {
            File::delete(storage_path("app/videos/{$content->content}"));
            $thumbnail_path = $video->snapshot(storage_path("app/videos/$fileName"));
            $duration = $video->length(storage_path("app/videos/$fileName"));
            $content = $content->update([
                "title" => $title,
                "description"=> $description,
                "content" => $fileName,
                "duration" => $duration,
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
    public function destroy(Content $content, LinkedList $list, Video $video) {
        $section = $content->section;
        $list->remove($content);
        $section->refresh();
        return $section->contents;
    }

    public function deleteMultiple(Request $request) {
        return $request->all();
    }
}
