<?php

namespace App\Services;
use App\Interfaces\Certificate;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Course;
use App\Models\Certificate as UserCertificate;
use Illuminate\Support\Facades\File;
use App\Models\User;


class CourseCertificate implements Certificate {
    public function generate($name, $duration, $course_title, $awarded_date) {
        $customPaper = [0,0,1056,516];
        $pdf = Pdf::loadView("certification", compact("name", "duration", "course_title", "awarded_date"))->setPaper($customPaper);
        return $pdf;
    }
    public function generateAndStore(Course $course) {
        $course_id = $course->id;
        $certificate = $this->generate(auth()->user()->name, $course->duration, $course->title, \Carbon\Carbon::now());
        $path = "certificates/" . auth()->user()->name . "/" . $course_id;

        if(!File::isDirectory($path)){
            File::makeDirectory($path, 0777, true, true);
        }
        $certificate_id = $course_id;

        // Validate if certificate exists or not

        $is_awarded = auth()->user()->certificates()->where("certificate", $path)->exists();


        if($is_awarded) return;

        \App\Models\Certificate::create([
            "user_id" => auth()->id(),
            "certificate_id" => $course->id,
            "certificate" => $path,
            "status" => 1
        ]);


        File::put($path . "/certificate.pdf", $certificate->output());
    }
    public function get(Course $course, User $user) {
        return UserCertificate::where("user_id", $user->id)->where("certificate_id", $course->id)->first();
    }
}
