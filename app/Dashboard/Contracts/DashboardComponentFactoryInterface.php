<?php

namespace App\Dashboard\Contracts;

interface DashboardComponentFactoryInterface
{
    public function createStatisticCards(array $metrics): array;

    public function createStatusChart(array $statusCounts): array;
}
