<?php

namespace App\Orders\Filters;

use Illuminate\Database\Eloquent\Builder;

interface OrderQueryFilterInterface
{
    public function apply(Builder $query, array $criteria): Builder;
}
