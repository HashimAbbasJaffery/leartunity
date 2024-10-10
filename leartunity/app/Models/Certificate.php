<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    protected $guarded = [];
    protected $with = ["course"];
    use HasFactory;
    public function user() {
        return $this->belongsTo(User::class);
    }
    public function course() {
        return $this->belongsTo(Course::class, "certificate_id");
    }
}
