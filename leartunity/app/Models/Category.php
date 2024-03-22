<?php

namespace App\Models;

use App\Models\Scopes\ActiveScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = ["id", "created_at", "updated_at"];
    use HasFactory;

    public function courses() {
        return $this->belongsToMany(Course::class, "course_category")
                ->where("status", 1);
    }

    protected $attributes = [
        "status" => 1,
    ];
    protected static function booted() {
        static::addGlobalScope(new ActiveScope);
    }
}
