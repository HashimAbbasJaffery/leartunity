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

    protected $guarded = [];
    public function course() {
        return $this->belongsTo(Course::class, "course_id");
    }
    public function contents(): MorphMany {
        return $this->MorphMany(Content::class, "contentable");
    }
}
