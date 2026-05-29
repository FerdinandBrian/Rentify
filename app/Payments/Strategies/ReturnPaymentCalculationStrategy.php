<?php

namespace App\Payments\Strategies;

use App\Models\Order;

class ReturnPaymentCalculationStrategy implements PaymentCalculationStrategy
{
    public function calculate(Order $order): array
    {
        $payment = $order->payments->first();
        $penalties = $order->payments->flatMap->penalties;
        $totalPenalty = (float) $penalties->sum('total_penalty');
        $basePrice = max(0, (float) ($payment?->total_price ?? 0) - $totalPenalty);
        $remainingPayment = $payment?->status === 'paid' ? 0 : $totalPenalty;

        return [
            'payment' => $payment,
            'penalties' => $penalties,
            'base_price' => $basePrice,
            'total_penalty' => $totalPenalty,
            'return_payment' => $totalPenalty,
            'remaining_payment' => $remainingPayment,
        ];
    }
}
