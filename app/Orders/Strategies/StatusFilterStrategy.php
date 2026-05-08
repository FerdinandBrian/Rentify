<?php

namespace App\Orders\Strategies;

use App\Exceptions\InvalidFilterException;
use Illuminate\Database\Eloquent\Builder;

class StatusFilterStrategy implements OrderQueryStrategyInterface
{
    private const ALLOWED_STATUSES = [
        'menunggu',
        'aktif',
        'selesai',
        'dibatalkan',
        'pending',
        'active',
        'completed',
        'cancelled',
    ];

    public function apply(Builder $query, array $criteria): Builder
    {
        $status = strtolower((string) ($criteria['status'] ?? ''));

        if ($status === '' || $status === 'semua') {
            return $query;
        }

        if (! in_array($status, self::ALLOWED_STATUSES, true)) {
            throw InvalidFilterException::status($status);
        }

        return $query->whereRaw('LOWER(status) = ?', [$status]);
    }
}
