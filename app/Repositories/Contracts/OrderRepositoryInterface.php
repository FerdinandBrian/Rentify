<?php

namespace App\Repositories\Contracts;

use App\Models\Order;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface OrderRepositoryInterface extends BaseRepositoryInterface
{
    public function paginateWithFilters(array $criteria, array $filters, int $perPage): LengthAwarePaginator;
}
