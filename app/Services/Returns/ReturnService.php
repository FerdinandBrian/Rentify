<?php

namespace App\Services\Returns;

use App\Models\Order;
use App\Payments\Strategies\PaymentCalculationStrategy;
use App\Repositories\Contracts\ReturnRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use InvalidArgumentException;

class ReturnService
{
    private const STANDARD_PENALTY_AMOUNTS = [
        'Late Return' => 100000.00,
        'Smoking in Car' => 500000.00,
        'Dirty Interior' => 200000.00,
    ];

    public function __construct(
        private readonly ReturnRepositoryInterface $returnRepository,
        private readonly PaymentCalculationStrategy $paymentStrategy
    ) {}

    public function getActiveOrdersWithPagination(int $perPage = 10): LengthAwarePaginator
    {
        return $this->returnRepository->paginateActiveOrders($perPage);
    }

    public function getCompletedOrdersWithPagination(int $perPage = 10): LengthAwarePaginator
    {
        return $this->returnRepository->paginateCompletedOrders($perPage);
    }

    public function getActiveOrderDetail(string $orderId): Order
    {
        $order = $this->returnRepository->findActiveOrder($orderId);

        if (!$order) {
            throw new InvalidArgumentException('Pesanan ini tidak ditemukan atau tidak dalam status aktif.');
        }

        return $order;
    }

    public function getCompletedOrderDetail(string $orderId): Order
    {
        $order = $this->returnRepository->findCompletedOrder($orderId);

        if (!$order) {
            throw new InvalidArgumentException('Pesanan ini belum selesai atau tidak ditemukan.');
        }

        return $order;
    }

    public function processReturn(array $data): Order
    {
        $order = $this->getActiveOrderDetail($data['order_id']);

        $appliedPenalties = $this->calculatePenalties($data);
        
        $paymentData = [
            'method' => $data['payment_method'] ?? null,
            'status' => $data['payment_status'] ?? null,
        ];

        $returnData = [
            'return_condition_note' => $data['return_condition_note'] ?? null,
            'returned_at' => now(),
        ];

        return $this->returnRepository->completeReturn($order, $appliedPenalties, $paymentData, $returnData);
    }

    public function calculateReturnPayment(Order $order): array
    {
        return $this->paymentStrategy->calculate($order);
    }

    private function calculatePenalties(array $data): array
    {
        $appliedPenalties = [];

        // Process standard penalties
        if (!empty($data['penalties'])) {
            foreach ($data['penalties'] as $type) {
                if (isset(self::STANDARD_PENALTY_AMOUNTS[$type])) {
                    $appliedPenalties[] = [
                        'type' => $type,
                        'amount' => self::STANDARD_PENALTY_AMOUNTS[$type]
                    ];
                }
            }
        }

        // Process custom penalty
        if (!empty($data['custom_penalty_desc']) && !empty($data['custom_penalty_amount'])) {
            $appliedPenalties[] = [
                'type' => $data['custom_penalty_desc'],
                'amount' => (float)$data['custom_penalty_amount']
            ];
        }

        return $appliedPenalties;
    }
}
