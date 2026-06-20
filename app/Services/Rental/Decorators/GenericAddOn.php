<?php

namespace App\Services\Rental\Decorators;

use App\Models\Addon;
use App\Services\Rental\AddOnDecorator;
use App\Services\Rental\Contracts\RentalComponent;

/**
 * Fallback decorator untuk addon yang tidak cocok dengan decorator spesifik
 * (Driver / GPS / Insurance / BabySeat). Menggunakan harga per-unit bila ada,
 * atau per-day sebagai cadangan, sehingga addon tidak pernah dibiarkan gratis
 * atau salah ditagih sebagai addon lain.
 */
class GenericAddOn extends AddOnDecorator
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
        $unitCost = $this->addon->price_per_unit ?? ($this->addon->price_per_day ?? 0) * $this->days;

        return $this->inner->getCost() + $unitCost;
    }

    public function getDescription(): string
    {
        return $this->inner->getDescription() . " + {$this->addon->name}";
    }
}
