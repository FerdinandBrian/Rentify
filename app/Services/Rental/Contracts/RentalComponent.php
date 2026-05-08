<?php

namespace App\Services\Rental\Contracts;

interface RentalComponent
{
    public function getCost(): float;
    public function getDescription(): string;
}