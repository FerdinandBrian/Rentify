<?php

namespace App\Repositories;

use App\Models\Order;
use App\Models\Payment;
use App\Repositories\Contracts\PaymentRepositoryInterface;

class PaymentRepository extends BaseRepository implements PaymentRepositoryInterface
{
    public function __construct(Payment $payment)
    {
        parent::__construct($payment);
    }

    public function create(array $data)
    {
        $payment = $this->model->newInstance();

        if (array_key_exists('id', $data)) {
            $payment->setAttribute('id', $data['id']);
        }

        $payment->fill($data);
        $payment->save();

        return $payment;
    }

    public function allWithOrder()
    {
        return $this->model->newQuery()->with('order')->get();
    }

    public function pendingOrders()
    {
        return Order::query()->where('status', 'pending')->get();
    }

    public function findWithDetails($id)
    {
        return $this->model->newQuery()
            ->with(['order', 'addons', 'penaltyorder'])
            ->find($id);
    }
}
