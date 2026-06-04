<?php

namespace App\Services\RootCrud;

use App\Models\Order;
use App\Repositories\Contracts\OrderRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class OrderService
{
    public function __construct(private readonly OrderRepositoryInterface $orderRepository) {}

    public function allWithCarAndUser()
    {
        return $this->orderRepository->allWithCarAndUser();
    }

    public function availableCars()
    {
        return $this->orderRepository->availableCars();
    }

    public function allCars()
    {
        return $this->orderRepository->allCars();
    }

    public function create(array $data): Order
    {
        return $this->orderRepository->create($data);
    }

    public function getById($id): Order
    {
        $order = $this->orderRepository->findById($id);

        if (! $order) {
            throw (new ModelNotFoundException)->setModel(Order::class, [$id]);
        }

        return $order;
    }

    public function update($id, array $data): Order
    {
        return $this->orderRepository->update($this->getById($id), $data);
    }

    public function delete($id): void
    {
        $this->orderRepository->delete($this->getById($id));
    }
}
