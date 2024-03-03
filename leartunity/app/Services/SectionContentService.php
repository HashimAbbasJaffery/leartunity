<?php 

namespace App\Services;
use App\Models\Content;
use App\Models\Section;
class SectionContentService {
   
    public function next_content(Content $content): ?Content {
        // Testing Case Next Content 
        $section = $content->section;
        // $next_content = $content->section->contents()->where("sequence", $content->sequence + 1)->first();
        $next_content = $content->next;
        // Testing Case if there is no next content, but there can be next section 
        if(!$next_content) {
            // Get the next section (in terms of sequence)
            $next_section = Section::where("sequence", $section->sequence + 1)->first();
            $next_content = $next_section?->contents()->where("sequence", 1)->first();
        }
        return $next_content;
    }
}