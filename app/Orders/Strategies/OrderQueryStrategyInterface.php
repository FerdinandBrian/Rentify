<?php

namespace App\Orders\Strategies;

use Illuminate\Database\Eloquent\Builder;

interface OrderQueryStrategyInterface
{
    public function apply(Builder $query, array $criteria): Builder;
}
