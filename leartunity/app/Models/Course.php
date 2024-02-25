<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
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
    public function comments() {
        return $this->hasMany(Comment::class);
    }
    public function contents() {
        return $this->hasManyThrough(Content::class, Section::class, "course_id", "contentable_id");
    }

    public function scopeFilter($query, array $filters = []) {
        
        // Filtration by category
        $query->when($filters["categories"] ?? false, function() use ($query, $filters) {
            $query->whereHas("categories", function($query) use($filters) {
                $query->whereIn("category_id", $filters["categories"]);
            });
        });
        
        // Filtration by price range 
        $query->when($filters["price_range"] ?? false, function() use($query, $filters) {
            $query->whereBetween("price", $filters["price_range"]);
        });

        // Searching from the keyword 

        $query->when($filters["search"] ?? false, function() use ($query, $filters) {
            $type = strtolower($filters["search"]->type);
            $query->where($type, "LIKE", "%" . $filters["search"]->keyword. "%");
        });

        return $query;
    }
}
