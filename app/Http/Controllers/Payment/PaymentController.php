<?php

use PaymentStrategy;
use Qris;
use VirtualAccount;

class PaymentController {
    public function VirtualAccount() {
        $payment = new PaymentStrategy(100);
        $payment->checkout(new VirtualAccount());
    }

    public function Qris() {
        $payment = new PaymentStrategy(100);
        $payment->checkout(new Qris());
    }
}