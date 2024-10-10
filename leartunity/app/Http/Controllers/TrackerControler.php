<?php

namespace App\Http\Controllers;

use App\Interfaces\Certificate;
use App\Interfaces\TrackingService;
use App\Models\Course;
use App\Services\CourseCertificate;
use Illuminate\Http\Request;
use App\Models\Content;
use Illuminate\Support\Arr;
use App\Models\User;
use Illuminate\Support\Facades\File;

class TrackerControler extends Controller
{
    public function __construct(
        protected TrackingService $service,
        protected Certificate $certificate
    ) {}

    public function update(Content $content, Course $course) {
        $service = $this->service->track($content, $course);
        [ $progress, $tracking_track ] = $service;
        $certificate = $this->certificate->get($course, User::find(auth()->id()));

        if($progress >= 100 && !$certificate && $course->is_certifiable) {
            $this->certificate->generateAndStore($course);
            $certificate = $this->certificate->get($course, User::find(auth()->id()));
        }


        if($tracking_track === -1) return [$course->tracker->progress, $certificate];

        // Store the results into the database (Core Code)
        $tracker = $course->tracker()->update([
            "tracking" => json_encode($tracking_track),
            "user_id" => auth()->user()->id,
            "progress" => $progress,
            "status" => 1
        ]);

        return [ $progress, $certificate];
    }
}
