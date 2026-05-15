<?php

namespace App\Repositories\User;

use App\Models\Order;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class UserOrderRepository
{
    public function paginateForUser(int $userId, ?array $statuses = null, int $perPage = 10): LengthAwarePaginator
    {
        $query = Order::query()
            ->with(['car.brand', 'payments'])
            ->where('User_id', $userId);

        if ($statuses) {
            $query->whereIn('status', $statuses);
        }

        return $query->latest('start_rent')->paginate($perPage)->withQueryString();
    }

    public function findForUser(string $orderId, int $userId): Order
    {
        return Order::query()
            ->with(['car.brand', 'payments.penaltyorder.penalty'])
            ->where('User_id', $userId)
            ->findOrFail($orderId);
    }

    public function create(array $data): Order
    {
        return Order::query()->create($data);
    }

    public function cancel(Order $order): Order
    {
        $order->update(['status' => 'dibatalkan']);

        return $order->refresh();
    }

    public function hasOverlappingBooking(string $carSeriesNumber, string $startDate, string $endDate): bool
    {
        return Order::query()
            ->where('Car_series_number', $carSeriesNumber)
            ->whereIn('status', ['menunggu', 'pending', 'aktif', 'active'])
            ->where(function (Builder $query) use ($startDate, $endDate) {
                $query->where('start_rent', '<=', $endDate)
                    ->where('end_rent', '>=', $startDate);
            })
            ->exists();
    }

    public function exists(string $orderId): bool
    {
        return Order::query()->whereKey($orderId)->exists();
    }

    public function countForUserByStatuses(int $userId, array $statuses): int
    {
        return Order::query()
            ->where('User_id', $userId)
            ->whereIn('status', $statuses)
            ->count();
    }
}
