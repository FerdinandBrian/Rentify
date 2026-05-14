<?php

namespace App\Services\User;

use App\Models\User;
use App\Repositories\User\UserDashboardRepository;

class UserDashboardService
{
    public function __construct(private readonly UserDashboardRepository $dashboardRepository) {}

    public function dataFor(User $user): array
    {
        $orders = $this->dashboardRepository->ordersForUser($user->id);
        $documents = $this->dashboardRepository->documentsForUser($user->id);

        return [
            'user' => $user,
            'recentOrders' => $this->dashboardRepository->recentOrdersForUser($user->id),
            'totalOrders' => $orders->count(),
            'activeRentals' => $orders->whereIn('status', ['aktif', 'active'])->count(),
            'completedOrders' => $orders->whereIn('status', ['selesai', 'completed'])->count(),
            'pendingOrders' => $orders->whereIn('status', ['menunggu', 'pending'])->count(),
            'totalDocuments' => $documents->count(),
            'verifiedDocuments' => $documents->where('status', 'approved')->count(),
            'pendingDocuments' => $documents->where('status', 'pending')->count(),
            'availableCars' => $this->dashboardRepository->availableCarsCount(),
        ];
    }
}
