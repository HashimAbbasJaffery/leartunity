<?php

namespace App\Http\Controllers;

use App\Interfaces\TrackingService;
use App\Models\Course;
use Illuminate\Http\Request;
use App\Models\Content;
use Illuminate\Support\Arr;

class TrackerControler extends Controller
{
    public function __construct(protected TrackingService $service) {}

    public function update(Content $content, Course $course) {
        $service = $this->service->track($content, $course);
        if(!$service) return;

        [ $progress, $tracking_track ] = $service;
        // Store the results into the database (Core Code)
        $course->tracker()->update([
            "tracking" => json_encode($tracking_track),
            "user_id" => auth()->user()->id,
            "progress" => $progress,
            "status" => 1
        ]);

        return 1;
    }
}
