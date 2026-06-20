<?php

namespace App\Observers;

use App\Models\Order;
use App\Notifications\OrderStatusChangedNotification;

class OrderStatusObserver
{
    public function updated(Order $order): void
    {
        if ($order->wasChanged('status')) {
            $user = $order->user;
            if ($user) {
                $user->notify(new OrderStatusChangedNotification($order));
            }
        }
    }
}
