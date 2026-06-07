<?php

namespace App\Cars\Filters;

use Illuminate\Database\Eloquent\Builder;

class DateAvailabilityFilter implements CarFilterInterface
{
    public function apply(Builder $query, array $filters): Builder
    {
        if (empty($filters['start_date']) || empty($filters['end_date'])) {
            return $query;
        }

        return $query->whereDoesntHave('orders', function (Builder $orderQuery) use ($filters) {
            $orderQuery
                ->whereIn('status', ['menunggu', 'pending', 'aktif', 'active'])
                ->where('start_rent', '<=', $filters['end_date'])
                ->where('end_rent', '>=', $filters['start_date']);
        });
    }
}
