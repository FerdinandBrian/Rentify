<?php

namespace App\Repositories;

use App\Models\Order;
use App\Models\Payment;
use App\Models\Penalty;
use App\Repositories\Contracts\ReturnRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class ReturnRepository extends BaseRepository implements ReturnRepositoryInterface
{
    public function __construct(Order $order)
    {
        parent::__construct($order);
    }

    public function paginateActiveOrders(int $perPage = 10, string $pageName = 'active_page'): LengthAwarePaginator
    {
        return $this->model->newQuery()
            ->with(['car', 'user', 'payments'])
            ->where('status', 'aktif')
            ->orderByDesc('id')
            ->paginate($perPage, ['*'], $pageName)
            ->withQueryString();
    }

    public function paginateCompletedOrders(int $perPage = 10, string $pageName = 'completed_page'): LengthAwarePaginator
    {
        return $this->model->newQuery()
            ->with(['car', 'user', 'payments.penalties'])
            ->where('status', 'selesai')
            ->orderByDesc('id')
            ->paginate($perPage, ['*'], $pageName)
            ->withQueryString();
    }

    public function findActiveOrder(string $orderId): ?Order
    {
        return $this->model->newQuery()
            ->with(['car', 'user', 'payments'])
            ->where('id', $orderId)
            ->where('status', 'aktif')
            ->first();
    }

    public function findCompletedOrder(string $orderId): ?Order
    {
        return $this->model->newQuery()
            ->with(['car', 'user', 'payments.penalties'])
            ->where('id', $orderId)
            ->where('status', 'selesai')
            ->first();
    }

    public function completeReturn(Order $order, array $appliedPenalties, array $paymentData): Order
    {
        return DB::transaction(function () use ($order, $appliedPenalties, $paymentData) {
            $payment = $order->payments->first();
            
            if (!$payment) {
                $payment = new Payment();
                $payment->id = (Payment::max('id') ?? 0) + 1;
                $payment->method = $paymentData['method'] ?? 'Cash';
                $payment->status = $paymentData['status'] ?? 'paid';
                $payment->total_price = 0.00;
                $payment->Order_id = $order->id;
                $payment->save();
            }

            $totalPenalty = 0.00;

            if (!empty($appliedPenalties)) {
                foreach ($appliedPenalties as $pData) {
                    $penalty = Penalty::create([
                        'type' => $pData['type'],
                        'total_penalty' => $pData['amount']
                    ]);
                    $payment->penalties()->attach($penalty->id);
                    $totalPenalty += $pData['amount'];
                }
            }

            if ($totalPenalty > 0 || !empty($paymentData['method']) || !empty($paymentData['status'])) {
                $payment->total_price += $totalPenalty;
                if (!empty($paymentData['status'])) {
                    $payment->status = $paymentData['status'];
                }
                if (!empty($paymentData['method'])) {
                    $payment->method = $paymentData['method'];
                }
                $payment->save();
            }

            $order->status = 'selesai';
            $order->save();

            $car = $order->car;
            if ($car) {
                $car->status = 'tersedia';
                $car->save();
            }

            return $order->refresh()->load(['car', 'payments.penalties']);
        });
    }
}
