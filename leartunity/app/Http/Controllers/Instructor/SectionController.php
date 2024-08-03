<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Http\Requests\SectionRequest;
use Exception;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Section;

class SectionController extends Controller
{
    protected Course $course;
    public function __construct(Request $request) {
        // $slug = "";
        // try {
        //     $slug = $request->route()->parameters()["course"];
        // } catch(Exception $e) {
        //     $section = $request->route()->parameters()["section"];
        //     $section = Section::find($section);
        //     $slug = $section->course->slug;
        // }
        // $this->middleware("is_course_owner:$strslug");stor
    }
    public function store(SectionRequest $request, Course $course) {

        $section_name = $request->section_name;
        $count = $course->sections->count();
        $section =$course->sections()->create([
            "section_name" => $section_name,
            "status" => 1,
            "sequence" => $count + 1
        ]);

        return Section::all();
    }

    public function destroy(Section $section) {
        $section->delete();

        return redirect()->back();
    }
    public function update(SectionRequest $request, Section $section) {
        $section_name = $request->section_name;
        $section->update([
            "section_name" => $section_name,
        ]);

        return 1;
    }
}
