<?php

namespace App\Repositories;

use App\Models\Order;
use App\Models\Payment;
use App\Models\Penalty;
use App\Repositories\Contracts\DashboardRepositoryInterface;
use Illuminate\Support\Carbon;

class DashboardRepository implements DashboardRepositoryInterface
{
    public function getMetrics(): array
    {
        $statusCounts = $this->getOrderStatusCounts();

        return [
            'total_orders' => Order::query()->count(),
            'today_orders' => $this->countTodayOrders(),
            'total_revenue' => (float) Payment::query()->sum('total_price'),
            'total_penalties' => (float) Penalty::query()->sum('total_penalty'),
            'unpaid_payments' => $this->countUnpaidPayments(),
            'status_counts' => $statusCounts,
            'latest_orders' => $this->getLatestOrders(),
        ];
    }

    private function countTodayOrders(): int
    {
        return Order::query()
            ->whereDate('start_rent', Carbon::today())
            ->count();
    }

    private function getOrderStatusCounts(): array
    {
        $rawCounts = Order::query()
            ->selectRaw('LOWER(status) as status_name, COUNT(*) as total')
            ->groupByRaw('LOWER(status)')
            ->pluck('total', 'status_name')
            ->all();

        return [
            'menunggu' => $this->sumAliases($rawCounts, ['menunggu', 'pending', 'waiting']),
            'aktif' => $this->sumAliases($rawCounts, ['aktif', 'active', 'berjalan']),
            'selesai' => $this->sumAliases($rawCounts, ['selesai', 'completed', 'complete', 'finish']),
            'dibatalkan' => $this->sumAliases($rawCounts, ['dibatalkan', 'cancelled', 'canceled', 'batal']),
        ];
    }

    private function countUnpaidPayments(): int
    {
        return Payment::query()
            ->whereIn('status', ['pending', 'menunggu', 'unpaid', 'belum bayar'])
            ->count();
    }

    private function getLatestOrders(): array
    {
        return Order::query()
            ->with(['car', 'payments'])
            ->latest('start_rent')
            ->limit(5)
            ->get()
            ->map(fn (Order $order) => [
                'id' => $order->id,
                'name' => $order->name,
                'car' => $order->car?->name ?? $order->Car_series_number,
                'status' => $order->status,
                'period' => $order->start_rent?->format('d M Y').' - '.$order->end_rent?->format('d M Y'),
                'total' => (float) $order->payments->sum('total_price'),
            ])
            ->all();
    }

    private function sumAliases(array $counts, array $aliases): int
    {
        return array_reduce($aliases, fn (int $total, string $alias) => $total + ($counts[$alias] ?? 0), 0);
    }
}
