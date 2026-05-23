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

<<<<<<< HEAD
        return $query->where('brand_id', $filters['brand']);
=======
        return $query->where('Brand_id', $filters['brand']);
>>>>>>> dfceab44e5d0f988ebd2414eade44c2f3175288c
    }
}
