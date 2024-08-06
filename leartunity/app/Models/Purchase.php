<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Purchase extends Model
{
    use HasFactory;
    protected $with = [ "course" ];
    protected $guarded = [];
    public function user(): BelongsTo {
        return $this->BelongsTo(User::class);
    }
    public function course() {
        return $this->belongsTo(Course::class, "purchase_product_id", "stripe_id");
    }
}
