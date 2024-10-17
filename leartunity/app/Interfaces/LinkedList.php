<?php
namespace App\Interfaces;
use App\Models;
use App\Models\Section;
use App\Models\Content;


interface LinkedList {
    public function get_first(Section $list);
    public function get_last(Section $list);
    public function add(Content $list);
    public function remove(Content $list);
    public function deleteMultiple(array $content_ids);
}
