<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use App\Models\Content;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Section extends Model
{
    use HasFactory;

    protected $with = "contents";
    protected $guarded = [];
    public function course() {
        return $this->belongsTo(Course::class, "course_id");
    }
    public function contents(): MorphMany {
        return $this->MorphMany(Content::class, "contentable");
    }
    public function next() {
        return $this->where("sequence", $this->sequence + 1)
                ->where("course_id", $this->id)
                ->get();
    }
    public function latest_content() {
        return $this->contents()
                ->latest()
                ->select(["id", "title", "content", "duration", "is_paid", "thumbnail"])
                ->first();
    }
}
