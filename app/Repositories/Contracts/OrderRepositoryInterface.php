<?php

namespace App\Repositories\Contracts;

use App\Models\Order;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface OrderRepositoryInterface extends BaseRepositoryInterface
{
    public function paginateWithStrategies(array $criteria, array $strategies, int $perPage): LengthAwarePaginator;
}
