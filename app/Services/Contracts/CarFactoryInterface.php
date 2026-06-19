<?php

namespace App\Services\Contracts;

use App\Models\Car;

interface CarFactoryInterface
{
    public function createCar(array $data): Car;
    public function updateCar(Car $car, array $data): Car;
}
