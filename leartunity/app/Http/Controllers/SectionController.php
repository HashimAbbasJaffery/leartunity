<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use App\Models\Section;

class SectionController extends Controller
{
    public function store(Request $request, Course $course) {
        $section_name = $request->section_name;
        $count = $course->sections->count();
        $course->sections()->create([
            "section_name" => $section_name,
            "status" => 1,
            "sequence" => $count + 1
        ]);

        return 1;
    }

    public function destroy(Section $section) {
        $section->delete();

        return redirect()->back();
    }
}
