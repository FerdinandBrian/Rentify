<?php

namespace App\Repositories\Contracts;

interface DashboardRepositoryInterface
{
    public function getMetrics(): array;
}
