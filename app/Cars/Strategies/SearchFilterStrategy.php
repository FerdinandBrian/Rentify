<?php

namespace App\Cars\Strategies;

use Illuminate\Database\Eloquent\Builder;

class SearchFilterStrategy implements CarFilterStrategyInterface
{
    public function apply(Builder $query, array $filters): Builder
    {
        if (empty($filters['search'])) {
            return $query;
        }

        return $query->where(function (Builder $innerQuery) use ($filters) {
            $innerQuery->where('name', 'like', '%' . $filters['search'] . '%')
                ->orWhere('series_number', 'like', '%' . $filters['search'] . '%');
        });
    }
}
