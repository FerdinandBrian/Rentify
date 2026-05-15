<?php

namespace App\Repositories;

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

    public function paginateWithStrategies(array $criteria, array $strategies, int $perPage): LengthAwarePaginator
    {
        $query = $this->model->newQuery()
            ->with(['car', 'payments'])
            ->withSum('payments as total_harga', 'total_price');

        foreach ($strategies as $strategy) {
            $query = $strategy->apply($query, $criteria);
        }

        return $query->paginate($perPage)->withQueryString();
    }

    public function findById($id): ?Order
    {
        return $this->model->newQuery()
            ->with(['car', 'user', 'payments'])
            ->find($id);
    }
}
