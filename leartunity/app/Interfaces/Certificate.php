<?php 

namespace App\Interfaces;
use App\Models\Course;

interface Certificate {
    public function generate($name, $duration, $course_title, $awarded_date);
    public function generateAndStore(Course $course);
}