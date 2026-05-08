<?php

namespace App\Repositories\Contracts;

use App\Models\Order;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface OrderRepositoryInterface
{
    public function paginateWithStrategies(array $criteria, array $strategies, int $perPage): LengthAwarePaginator;

    public function findById(string $bookingId): ?Order;

    public function update(Order $booking, array $data): Order;

    public function delete(string $bookingId): void;
}
