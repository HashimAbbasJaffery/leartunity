<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Section;
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

    public function section(): MorphOne {
        return $this->morphOne(Section::class, "contentable");
    }
}
