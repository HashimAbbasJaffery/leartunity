<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Achievement extends Model
{
    protected $table = "achievement";
    use HasFactory;
    public function achievementable(): MorphTo {
        return $this->morphTo();
    }
    public function scopeAchieveables($query, array $information) {
        $query->where("type", $information["type"])
                ->where("quantity", "<=", $information["quantity"]);
        return $query;
    }
    public function achievements() {
        return $this->belongsToMany(Achievement::class, "achievement_user");
    }
}
