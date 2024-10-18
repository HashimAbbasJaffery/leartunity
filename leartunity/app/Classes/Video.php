<?php

namespace App\Classes;
use FFMpeg\Coordinate\TimeCode;
use FFMpeg\FFMpeg;
use Storage;

class Video {
    public function snapshot($videoPath) {
        $fileName = time() . ".jpg";
        $thumbnail_path = public_path("thumbnails/$fileName");
        $ffmpeg = FFMpeg::create();
        $video = $ffmpeg->open($videoPath);

        $video->frame(TimeCode::fromSeconds(2))
                ->save($thumbnail_path);

        return $fileName;
    }
    public function length($video) {
        $ffmpeg = FFMpeg::create()->getFFProbe();
        $duration = $ffmpeg->format($video)->get("duration");

        return $duration;
    }
    public function delete($video) {
        $is_deleted = Storage::delete($video);
        return $is_deleted;
    }
}
