<?php 
namespace App\Interfaces;

use App\Models\Content;
use App\Models\Course;

interface TrackingService {
    public function track(Content $content, Course $course);
}