<?php

namespace App\Cars\Strategies;

use Illuminate\Database\Eloquent\Builder;

interface CarFilterStrategyInterface
{
    public function apply(Builder $query, array $filters): Builder;
}
