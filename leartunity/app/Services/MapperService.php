<?php

namespace App\Services;

class MapperService {
    function mapToContentType($type) {
        if($type === 1) return "tracking";
        if($type === 2) return "quiz_tracker";
    }
}
