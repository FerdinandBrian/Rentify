<?php

namespace App\Repositories\Contracts;

interface PaymentRepositoryInterface extends BaseRepositoryInterface
{
    public function allWithOrder();

    public function pendingOrders();

    public function findWithDetails($id);
}
