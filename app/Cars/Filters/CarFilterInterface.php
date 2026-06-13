<?php

namespace App\Cars\Filters;

use Illuminate\Database\Eloquent\Builder;

interface CarFilterInterface
{
    public function apply(Builder $query, array $filters): Builder;
}
