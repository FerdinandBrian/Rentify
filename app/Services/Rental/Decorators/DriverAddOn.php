<?php

namespace App\Services\Rental\Decorators;

use App\Models\Addon;
use App\Services\Rental\AddOnDecorator;
use App\Services\Rental\Contracts\RentalComponent;

class DriverAddOn extends AddOnDecorator
{
    protected Addon $addon;
    protected int $days;

    public function __construct(RentalComponent $inner, Addon $addon, int $days)
    {
        parent::__construct($inner);
        $this->addon = $addon;
        $this->days = $days;
    }

    public function getCost(): float
    {
        return $this->inner->getCost() + (($this->addon->price_per_day ?? 0) * $this->days);
    }

    public function getDescription(): string
    {
        return $this->inner->getDescription() . " + Driver ({$this->days} hari)";
    }
}
