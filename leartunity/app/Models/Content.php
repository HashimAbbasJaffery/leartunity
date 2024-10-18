<?php

namespace App\Models;

use App\Classes\Video;
use File;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Section;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Storage;

class Content extends Model
{
    protected $with = "comments";
    use HasFactory;
    protected $guarded = [];


    public function contentable(): MorphTo {
        return $this->morphTo();
    }

    public function section(): BelongsTo {
        return $this->belongsTo(Section::class, "contentable_id");
    }
    public function next() {
        return $this->belongsTo(Content::class, "next_video");
    }
    public function previous() {
        return $this->belongsTo(Content::class, "previous_video");
    }
    public function comments() {
        return $this->hasMany(Comment::class)->whereNull("replies_to");
    }

    protected static function booted() {
        static::deleting(function(Content $content) {
            File::delete(storage_path("app/videos/{$content->content}"));
        });
    }
}
