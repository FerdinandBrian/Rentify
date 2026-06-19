<?php

namespace App\Repositories;

use App\Models\Car;
use App\Models\Order;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\OrderRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class OrderRepository extends BaseRepository implements OrderRepositoryInterface
{
    public function __construct(Order $order)
    {
        parent::__construct($order);
    }

    protected function getFilterQuery()
    {
        return parent::getFilterQuery()
            ->with(['car', 'payments'])
            ->withSum('payments as total_harga', 'total_price');
    }

    public function findById($id): ?Order
    {
        return $this->model->newQuery()
            ->with(['car', 'user', 'payments'])
            ->find($id);
    }

    public function allWithCarAndUser()
    {
        return $this->model->newQuery()->with(['car', 'user'])->get();
    }

    public function availableCars()
    {
        return Car::query()->where('status', 'available')->get();
    }

    public function allCars()
    {
        return Car::query()->get();
    }
}
