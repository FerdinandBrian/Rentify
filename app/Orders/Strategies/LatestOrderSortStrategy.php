<?php

namespace App\Orders\Strategies;

use Illuminate\Database\Eloquent\Builder;

class LatestOrderSortStrategy implements OrderQueryStrategyInterface
{
    public function apply(Builder $query, array $criteria): Builder
    {
        return $query->orderByDesc('start_rent')->orderByDesc('id');
    }
}
