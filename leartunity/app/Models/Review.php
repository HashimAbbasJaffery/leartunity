<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Review extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function reviewable(): MorphTo {
        return $this->morphTo();
    }

    public static function getUser($id) {
        return User::find($id);
    }

    protected function reviews(): Attribute {
        return Attribute::make(
            get: fn(string $value) => json_decode($value),
            set: fn(array $value) => json_encode($value) 
        );
    }
}
