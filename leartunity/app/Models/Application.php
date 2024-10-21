<?php

namespace App\Models;
use App\Enums\Qualification;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;
    protected $guarded = ["id", "created_at", "updated_at"];
    protected $with = ["user"];
    public function user() {
        return $this->belongsTo(User::class);
    }
    public function qualification(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => strtolower(Qualification::get((int)$value))
        );
    }
}
