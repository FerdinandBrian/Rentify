<?php

namespace App\Payments\Strategies;

use App\Models\Order;

interface PaymentCalculationStrategy
{
    public function calculate(Order $order): array;
}
