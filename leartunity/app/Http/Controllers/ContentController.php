<?php

namespace App\Http\Controllers;

use App\Interfaces\LinkedList;
use App\Models\Content;
use App\Models\Course;
use App\Models\Section;
use FFMpeg\FFProbe;
use Illuminate\Http\Request;
use Pion\Laravel\ChunkUpload\Exceptions\UploadMissingFileException;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;

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
    public function store(Request $request, Section $section, LinkedList $list) {
        $title = $request->title;
        $description = $request->description;
        $reciever = new FileReceiver("file", $request, HandlerFactory::classFromRequest($request));

        if($reciever->isUploaded() === false) {
            throw new UploadMissingFileException();
        }

        $save = $reciever->receive();

        if($save->isFinished()) {
            $file = $save->getFile();
            $fileName = time() . $file->getClientOriginalName();
            $file->move(public_path("uploads"), $fileName);


            $count = $section->contents->count();
            $previous_content = $list->get_last($section);
            
            $new_content = $section->contents()->create([
                "title" => $title,
                "status" => 1,
                "content" => $fileName,
                "duration" => 400,
                "is_paid" => 1,
                "sequence" => $count +  1,
                "description" => $description,
                "previous_video" => $previous_content?->id
            ]);
            $previous_content?->update([
                "next_video" => $new_content->id
            ]);
        }

        $handler = $save->handler();

        return response()->json([
            "done" => $handler->getPercentageDone(),
            'status' => true
        ]);

    }
    public function destroy(Content $content, LinkedList $list) {
        $list->remove($content);
        return redirect()->back();
    }
}
