<?php

use PaymentInterface;

class Qris implements PaymentInterface {
    public function pay(int $amount) {
        echo "Paid $amount using QRIS.";
    }
}