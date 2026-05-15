<?php

namespace App\Repositories;

use App\Models\Car;
use App\Repositories\Contracts\CarRepositoryInterface;

class CarRepository extends BaseRepository implements CarRepositoryInterface
{
    /**
     * CarRepository constructor.
     *
     * @param Car $car
     */
    public function __construct(Car $car)
    {
        parent::__construct($car);
    }

    /**
     * @inheritDoc
     */
    public function getAllWithBrands()
    {
        return $this->model->newQuery()->with('brand')->get();
    }

    /**
     * @inheritDoc
     */
    public function getUniqueTypes()
    {
        return $this->model->newQuery()
            ->select('type')
            ->distinct()
            ->orderBy('type')
            ->pluck('type');
    }
}
