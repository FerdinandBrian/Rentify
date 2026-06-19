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
        return $this->model->newQuery()->with(['brand', 'images'])->get();
    }

    protected function getFilterQuery()
    {
        return parent::getFilterQuery()
            ->with(['brand', 'images'])
            ->orderBy('name');
    }

    /**
     * @inheritDoc
     */
    public function getFilteredWithBrands(array $filters)
    {
        $query = $this->getFilterQuery();

        $criteria = [
            'brand' => $filters['brand_id'] ?? null,
            'type'  => $filters['type'] ?? null,
        ];

        $queryFilters = [
            new \App\Cars\Filters\BrandFilter,
            new \App\Cars\Filters\TypeFilter,
        ];

        foreach ($queryFilters as $filter) {
            $query = $filter->apply($query, $criteria);
        }

        return $query->get();
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
