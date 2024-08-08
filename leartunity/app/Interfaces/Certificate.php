<?php

namespace App\Interfaces;
use App\Models\Course;
use App\Models\User;

interface Certificate {
    public function generate($name, $duration, $course_title, $awarded_date);
    public function generateAndStore(Course $course);
    public function get(Course $course, User $user);
}
