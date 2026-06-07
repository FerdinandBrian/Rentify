<?php

namespace App\Orders\Filters;

use Illuminate\Database\Eloquent\Builder;

class LatestOrderSortFilter implements OrderQueryFilterInterface
{
    public function apply(Builder $query, array $criteria): Builder
    {
        return $query->orderByDesc('start_rent')->orderByDesc('id');
    }
}
