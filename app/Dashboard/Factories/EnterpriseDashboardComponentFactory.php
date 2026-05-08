<?php

namespace App\Dashboard\Factories;

use App\Dashboard\Contracts\DashboardComponentFactoryInterface;

class EnterpriseDashboardComponentFactory implements DashboardComponentFactoryInterface
{
    public function createStatisticCards(array $metrics): array
    {
        return [
            $this->makeCard('Total Pesanan', $metrics['total_orders'], 'fas fa-clipboard-list', 'primary'),
            $this->makeCard('Pesanan Hari Ini', $metrics['today_orders'], 'fas fa-calendar-day', 'success'),
            $this->makeCard('Pendapatan', $this->formatCurrency($metrics['total_revenue']), 'fas fa-wallet', 'warning'),
            $this->makeCard('Total Denda', $this->formatCurrency($metrics['total_penalties'] ?? 0), 'fas fa-exclamation-circle', 'danger'),
        ];
    }

    public function createStatusChart(array $statusCounts): array
    {
        return [
            'labels' => ['Menunggu', 'Aktif', 'Selesai', 'Dibatalkan'],
            'values' => [
                $statusCounts['menunggu'] ?? 0,
                $statusCounts['aktif'] ?? 0,
                $statusCounts['selesai'] ?? 0,
                $statusCounts['dibatalkan'] ?? 0,
            ],
            'colors' => ['#f08c00', '#1f7a8c', '#2f9e44', '#d9480f'],
        ];
    }

    private function makeCard(string $label, int|string $value, string $icon, string $tone): array
    {
        return compact('label', 'value', 'icon', 'tone');
    }

    private function formatCurrency(float $amount): string
    {
        return 'Rp '.number_format($amount, 0, ',', '.');
    }
}
