<?php 

namespace App\Services;
use App\Interfaces\TrackingService;
use App\Models\Content;
use App\Models\Course;
use Illuminate\Support\Arr;

class VideoTrackingService implements TrackingService {
    public function track(Content $content, Course $course) {
        
        $trackerInfo = [
            "id" => $content->id,
            "status" => "completed"
        ];
        $course_tracker = $course->tracker;
        $tracking_track = json_decode($course_tracker->tracking);
        
        
        $ids = Arr::pluck($tracking_track, "id");
        $is_already_tracked = in_array($content->id, $ids);
        if($is_already_tracked) return 0;

        // Tracker JSON Data
        $tracking_track[] = $trackerInfo;

        // Get all of the contents of specific course
        $contents = $course->contents;

        // Get the completed / Watched contents
        $completedContents = count($tracking_track);

        // Put them into the formula to generate the progress
        $progress = ($completedContents / count($contents)) * 100;

        return [ round($progress, 2), $tracking_track ];
    }
}