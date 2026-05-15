<?php

namespace App\Services\Rental;

use App\Services\Rental\Contracts\RentalComponent;

abstract class AddOnDecorator implements RentalComponent
{
    protected RentalComponent $inner;

    public function __construct(RentalComponent $inner)
    {
        $this->inner = $inner;
    }
}