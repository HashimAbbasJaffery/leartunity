<?php 

namespace App\Services;
use App\Interfaces\LinkedList;
use App\Models\Section;
use App\Models\Content;

class ContentService implements LinkedList {
    public function add(Content $content) {

    }
    public function remove(Content $content) {
        $next = $content->next;
        $previous = $content->previous;
        if($previous) {
            $previous->next_video = $next?->id ?? null;
            $previous->save();
        }

        if($next) {
            $next->previous_video = $previous?->id ?? null;
            $next->save();
        }

        $content->next_video = null;
        $content->previous_video = null;
        $content->save();
        
        $content->delete();
    }
    public function get_first(Section $section) {
        $content = $section->contents()->orderBy("sequence")->first();
        return $content;
    }
    public function get_last(Section $section) {  
        $content = $this->get_first($section);
        
        while($content?->next) {
            $content = $content->next;
        }

        return $content;
    }
}