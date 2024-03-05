<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Section;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Content extends Model
{
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
}
