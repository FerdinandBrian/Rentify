<?php

use PaymentInterface;

class VirtualAccount implements PaymentInterface {
    public function pay(int $amount) {
        echo "Paid $amount using Virtual Account.";
    }
}