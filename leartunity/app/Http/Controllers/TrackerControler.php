<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use App\Models\Content;

class TrackerControler extends Controller
{
    public function update(Content $content, Course $course) {
        $trackerInfo = [
            "id" => $content->id,
            "status" => "completed"
        ];
        $course_tracker = $course->tracker;
        $tracking_track = json_decode($course_tracker->tracking);
        
        // Tracker JSON Data
        $tracking_track[] = $trackerInfo;

        // Get all of the contents of specific course
        $contents = $course->contents;

        // Get the completed / Watched contents
        $completedContents = count($tracking_track);

        // Put them into the formula to generate the progress
        $progress = ($completedContents / count($contents)) * 100;
        
        // Store the results into the database
        $course->tracker()->update([
            "tracking" => json_encode($tracking_track),
            "user_id" => auth()->user()->id,
            "progress" => $progress,
            "status" => 1
        ]);

        return 1;

        
    }
}
