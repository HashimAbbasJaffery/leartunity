<?php


namespace App\Services;
use FFMpeg\Coordinate\TimeCode;
use FFMpeg\FFMpeg;
class ContentDescription {

    public function thumbnail($videoPath) {
        $fileName = time() . ".jpg";
        $thumbnail_path = public_path("thumbnails/" . $fileName);
        $ffmpeg = FFMpeg::create();
        $video = $ffmpeg->open($videoPath);

        $video->frame(TimeCode::fromSeconds(2))
                ->save($thumbnail_path);

        return $fileName;
    }

}
