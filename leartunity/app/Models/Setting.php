<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = "general_setting";
    protected $guarded = ["id", "created_at","updated_at"];
    use HasFactory;
}
