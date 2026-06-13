<?php

namespace App\Payments\Strategies;

use App\Models\Order;

class ReturnPaymentCalculationStrategy implements PaymentCalculationStrategy
{
    public function calculate(Order $order): array
    {
        $days = $order->start_rent && $order->end_rent ? $order->start_rent->diffInDays($order->end_rent) + 1 : 0;
        $fallbackBasePrice = ($order->car->price ?? 0) * $days;

        $payment    = $order->payments->first();
        $penalties  = $order->payments->flatMap->penalties;
        $totalPenalty = (float) $penalties->sum('total_penalty');

        $fullPrice  = (float) ($payment?->total_price ?? 0);
        
        if ($fullPrice <= 0) {
            $basePrice = $fallbackBasePrice;
            $fullPrice = $basePrice + $totalPenalty;
        } else {
            $basePrice = max(0, $fullPrice - $totalPenalty);
            if ($basePrice <= 0 && $fallbackBasePrice > 0) {
                $basePrice = $fallbackBasePrice;
                $fullPrice = $basePrice + $totalPenalty;
            }
        }

        // Customer needs to pay the penalty amount additionally (beyond the original rent).
        // If already marked paid, remaining = 0.
        $remainingPayment = ($payment?->status === 'paid') ? 0.0 : $totalPenalty;

        return [
            'payment'           => $payment,
            'penalties'         => $penalties,
            'base_price'        => $basePrice,      // original rent
            'total_penalty'     => $totalPenalty,
            'return_payment'    => $totalPenalty,   // additional charge for penalties
            'remaining_payment' => $remainingPayment,
        ];
    }
}
