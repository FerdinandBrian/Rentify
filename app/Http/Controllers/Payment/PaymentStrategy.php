<?php

use PaymentInterface;

class PaymentStrategy {
    private $amount;
    
    public function __construct(int $amount) {
        $this->amount = $amount;
    }

    public function checkout(PaymentInterface $method) {
        return $method->pay($this->amount);
    }
}

