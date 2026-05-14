<?php

namespace App\Cars\Strategies;

use Illuminate\Database\Eloquent\Builder;

class BrandFilterStrategy implements CarFilterStrategyInterface
{
    public function apply(Builder $query, array $filters): Builder
    {
        if (empty($filters['brand'])) {
            return $query;
        }

        return $query->where('Brand_id', $filters['brand']);
    }
}
