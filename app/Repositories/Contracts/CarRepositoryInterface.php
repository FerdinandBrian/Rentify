<?php

namespace App\Repositories\Contracts;

interface CarRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Get all cars with their associated brands.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllWithBrands();

    /**
     * Get cars filtered by brand and type with their associated brands.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getFilteredWithBrands(array $filters);

    /**
     * Get unique car types.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getUniqueTypes();
}
