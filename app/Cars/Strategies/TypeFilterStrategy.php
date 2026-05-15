<?php

namespace App\Cars\Strategies;

use Illuminate\Database\Eloquent\Builder;

class TypeFilterStrategy implements CarFilterStrategyInterface
{
    public function apply(Builder $query, array $filters): Builder
    {
        if (empty($filters['type'])) {
            return $query;
        }

        return $query->where('type', $filters['type']);
    }
}
