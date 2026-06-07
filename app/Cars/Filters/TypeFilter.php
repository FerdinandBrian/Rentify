<?php

namespace App\Cars\Filters;

use Illuminate\Database\Eloquent\Builder;

class TypeFilter implements CarFilterInterface
{
    public function apply(Builder $query, array $filters): Builder
    {
        if (empty($filters['type'])) {
            return $query;
        }

        return $query->where('type', $filters['type']);
    }
}
