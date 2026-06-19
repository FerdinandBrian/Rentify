<?php

namespace App\Observers;

use App\Models\Order;

class CarAvailabilityObserver
{
    public function updated(Order $order): void
    {
        if ($order->wasChanged('status')) {
            $status = strtolower($order->status);
            if (in_array($status, ['dibatalkan', 'cancelled', 'canceled'], true)) {
                $car = $order->car;
                if ($car) {
                    $car->status = 'tersedia';
                    $car->save();
                }
            }
        }
    }
}
