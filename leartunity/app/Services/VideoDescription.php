<?php 

namespace App\Services;
use App\Models\Content;
use FFMpeg\FFMpeg;

class VideoDescription {
    public function getDuration($name) {
        $video = public_path("uploads/" . $name);
        
        $ffmpeg = FFMpeg::create()->getFFProbe();
        $duration = $ffmpeg->format($video)->get("duration");

        return $duration;
    }
}