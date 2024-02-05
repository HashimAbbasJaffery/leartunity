<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $guarded = [];
    
    public function categories() {
        return $this->belongsToMany(Category::class, "course_category")
                ->where("status", 1);
    }
    public function author() {
        return $this->belongsTo(User::class, "author_id");
    }
    public function reviews() {
        return $this->morphOne(Review::class, "reviewable");
    }
    public function sections() {
        return $this->hasMany(Section::class);
    }
}
