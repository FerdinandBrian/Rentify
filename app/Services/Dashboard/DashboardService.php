<?php

namespace App\Services\Dashboard;

use App\Dashboard\Contracts\DashboardComponentFactoryInterface;
use App\Repositories\Contracts\DashboardRepositoryInterface;
use Illuminate\Support\Facades\Cache;

class DashboardService
{
    public const CACHE_KEY = 'admin_dashboard_metrics';

    public function __construct(
        private readonly DashboardRepositoryInterface $dashboardRepository,
        private readonly DashboardComponentFactoryInterface $componentFactory,
    ) {}

    public function getAdminDashboard(): array
    {
        $metrics = Cache::remember(self::CACHE_KEY, now()->addMinutes(5), function () {
            return $this->dashboardRepository->getMetrics();
        });

        return [
            'metrics' => $metrics,
            'statCards' => $this->componentFactory->createStatisticCards($metrics),
            'statusChart' => $this->componentFactory->createStatusChart($metrics['status_counts']),
        ];
    }

    public static function forgetCache(): void
    {
        Cache::forget(self::CACHE_KEY);
    }
}
