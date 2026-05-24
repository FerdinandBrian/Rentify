<?php

namespace App\Services\Rental\Decorators;

use App\Models\Addon;
use App\Services\Rental\AddOnDecorator;

class GPSAddOn extends AddOnDecorator
{
    protected Addon $addon;

    public function __construct($inner, Addon $addon)
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
        return $this->inner->getDescription() . " + GPS";
    }
}
