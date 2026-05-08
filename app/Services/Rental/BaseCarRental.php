<?php

namespace App\Services\Rental;

use App\Models\Car;
use App\Services\Rental\Contracts\RentalComponent;

class BaseCarRental implements RentalComponent
{
    protected Car $car;
    protected int $days;

    public function __construct(Car $car, int $days)
    {
        $this->car = $car;
        $this->days = $days;
    }

    public function getCost(): float
    {
        return $this->car->price * $this->days;
    }

    public function getDescription(): string
    {
        return "Mobil: {$this->car->name} ({$this->days} hari)";
    }
}