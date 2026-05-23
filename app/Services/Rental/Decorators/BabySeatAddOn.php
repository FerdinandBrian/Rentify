<?php

namespace App\Services\Rental\Decorators;

use App\Models\Addon;
use App\Services\Rental\AddOnDecorator;
use App\Services\Rental\Contracts\RentalComponent;

class BabySeatAddOn extends AddOnDecorator
{
    protected Addon $addon;

    public function __construct(RentalComponent $inner, Addon $addon)
    {
        parent::__construct($inner);
        $this->addon = $addon;
    }

    public function getCost(): float
    {
        return $this->inner->getCost() + ($this->addon->price_per_unit ?? 0);
    }

    public function getDescription(): string
    {
        return $this->inner->getDescription() . ' + Baby Seat';
    }
}
