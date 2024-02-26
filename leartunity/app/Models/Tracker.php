<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tracker extends Model
{
    protected $table = "course_tracker";
    protected $guarded = [];
    use HasFactory;

    public function course() {
        return $this->belongsTo(Course::class);
    }
}
