<?php

interface PaymentInterface {
    public function pay(int $amount);
}