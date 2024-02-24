<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $guarded = [];
    public function course(){
        return $this->belongsTo(Course::class);
    }
    public function replies() {
        return $this->hasMany(Comment::class, "replies_to");
    }
    public function user() {
        return $this->belongsTo(User::class);
    }
    use HasFactory;
}
