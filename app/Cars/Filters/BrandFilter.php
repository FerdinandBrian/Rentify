<?php

namespace App\Cars\Filters;

use Illuminate\Database\Eloquent\Builder;

class BrandFilter implements CarFilterInterface
{
    public function apply(Builder $query, array $filters): Builder
    {
        if (empty($filters['brand'])) {
            return $query;
        }

        return $query->where('brand_id', $filters['brand']);
    }
}
