<?php

namespace App\Services\RootCrud;

use App\Models\Payment;
use App\Repositories\Contracts\PaymentRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PaymentService
{
    public function __construct(private readonly PaymentRepositoryInterface $paymentRepository) {}

    public function allWithOrder()
    {
        return $this->paymentRepository->allWithOrder();
    }

    public function pendingOrders()
    {
        return $this->paymentRepository->pendingOrders();
    }

    public function create(array $data): Payment
    {
        return $this->paymentRepository->create($data);
    }

    public function getById($id): Payment
    {
        $payment = $this->paymentRepository->findById($id);

        if (! $payment) {
            throw (new ModelNotFoundException)->setModel(Payment::class, [$id]);
        }

        return $payment;
    }

    public function getDetail($id): Payment
    {
        $payment = $this->paymentRepository->findWithDetails($id);

        if (! $payment) {
            throw (new ModelNotFoundException)->setModel(Payment::class, [$id]);
        }

        return $payment;
    }

    public function update($id, array $data): Payment
    {
        return $this->paymentRepository->update($this->getById($id), $data);
    }

    public function delete($id): void
    {
        $this->paymentRepository->delete($this->getById($id));
    }
}
