<?php

namespace App\Repositories\Contracts;

use App\Models\Order;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ReturnRepositoryInterface
{
    public function paginateActiveOrders(int $perPage = 10, string $pageName = 'active_page'): LengthAwarePaginator;

    public function paginateCompletedOrders(int $perPage = 10, string $pageName = 'completed_page'): LengthAwarePaginator;

    public function findActiveOrder(string $orderId): ?Order;

    public function findCompletedOrder(string $orderId): ?Order;

    public function completeReturn(Order $order, array $appliedPenalties, array $paymentData): Order;
}
