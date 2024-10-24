<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\AnnouncementMail;
use App\Models\Course;
use Illuminate\Http\Request;
use Mail;

class AnnouncementController extends Controller
{
    public function create(Course $course) {
        $recipients = $course->purchases->pluck("user.email");
        $announcement = request()->announcement;
        $subject = request()->subject;

        foreach($recipients as $recipient) {
            Mail::to($recipient)
                ->queue(new AnnouncementMail($subject, $announcement));
        }
    }
}
