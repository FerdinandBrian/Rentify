<?php

namespace App\Repositories\User;

use App\Models\Car;
use App\Models\Document;
use App\Models\Order;
use Illuminate\Database\Eloquent\Collection;

class UserDashboardRepository
{
    public function ordersForUser(int $userId): Collection
    {
        return Order::query()
            ->with(['car.brand', 'payments'])
            ->where('User_id', $userId)
            ->latest('start_rent')
            ->get();
    }

    public function recentOrdersForUser(int $userId, int $limit = 5): Collection
    {
        return Order::query()
            ->with(['car.brand', 'payments'])
            ->where('User_id', $userId)
            ->latest('start_rent')
            ->limit($limit)
            ->get();
    }

    public function documentsForUser(int $userId): Collection
    {
        return Document::query()
            ->where('user_id', $userId)
            ->latest()
            ->get();
    }

    public function availableCarsCount(): int
    {
        return Car::query()
            ->whereIn('status', ['tersedia', 'available', 'Tersedia'])
            ->count();
    }
}
