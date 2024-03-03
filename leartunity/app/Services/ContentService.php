<?php 

namespace App\Services;
use App\Interfaces\LinkedList;
use App\Models\Section;
use App\Models\Content;

class ContentService implements LinkedList {
    public function add(Content $content) {

    }
    public function remove(Content $content) {

    }
    public function get_first(Section $section) {
        $content = $section->contents()->orderBy("sequence")->first();
        return $content;
    }
    public function get_last(Section $section) {  
        $content = $this->get_first($section);
        
        while($content->next) {
            $content = $content->next;
        }

        return $content;
    }
}