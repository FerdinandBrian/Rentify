<?php

namespace App\Observers;

use App\Services\Dashboard\DashboardService;

class DashboardCacheObserver
{
    public function saved(): void
    {
        DashboardService::forgetCache();
    }

    public function deleted(): void
    {
        DashboardService::forgetCache();
    }
}
