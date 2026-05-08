<?php

namespace App\Repositories;

use App\Models\Order;
use App\Repositories\Contracts\OrderRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class OrderRepository implements OrderRepositoryInterface
{
    public function paginateWithStrategies(array $criteria, array $strategies, int $perPage): LengthAwarePaginator
    {
        $query = Order::query()
            ->with(['car', 'payments'])
            ->withSum('payments as total_harga', 'total_price');

        foreach ($strategies as $strategy) {
            $query = $strategy->apply($query, $criteria);
        }

        return $query->paginate($perPage)->withQueryString();
    }

    public function findById(string $bookingId): ?Order
    {
        return Order::query()
            ->with(['car', 'user', 'payments'])
            ->find($bookingId);
    }

    public function update(Order $booking, array $data): Order
    {
        $booking->update($data);

        return $booking->refresh();
    }

    public function delete(string $bookingId): void
    {
        Order::query()->whereKey($bookingId)->delete();
    }
}
