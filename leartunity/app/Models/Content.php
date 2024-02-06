<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Section;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Content extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function section() {
        return $this->belongsTo(Section::class);
    }
    public function contentable(): MorphTo {
        return $this->morphTo();
    }
}
