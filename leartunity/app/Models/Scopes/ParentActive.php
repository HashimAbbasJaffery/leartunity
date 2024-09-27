<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Log;

class ParentActive implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    protected $parents = [
        "Course" => "categories"
    ];
    public function apply(Builder $builder, Model $model): void
    {
        $builder->whereHas("categories", function($query) {
            $query->whereStatus(1);
        });

    }
}
