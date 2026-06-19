<?php

namespace App\Services\Rental;

use App\Models\Addon;
use App\Models\Car;
use App\Services\Rental\Contracts\RentalComponent;
use App\Services\Rental\Decorators\BabySeatAddOn;
use App\Services\Rental\Decorators\DriverAddOn;
use App\Services\Rental\Decorators\GPSAddOn;
use App\Services\Rental\Decorators\InsuranceAddOn;

class RentalBuilderService
{
    public function build(Car $car, int $days, array $addons): RentalComponent
    {
        $rental = new BaseCarRental($car, $days);

        foreach ($addons as $addon) {
            $rental = $this->decorate($rental, $addon, $days);
        }

        return $rental;
    }

    private function decorate(RentalComponent $rental, Addon $addon, int $days): RentalComponent
    {
        $name = strtolower($addon->name);

        return match (true) {
            str_contains($name, 'driver')                                        => new DriverAddOn($rental, $addon, $days),
            str_contains($name, 'gps')                                           => new GPSAddOn($rental, $addon),
            str_contains($name, 'insurance') || str_contains($name, 'asuransi') => new InsuranceAddOn($rental, $addon),
            str_contains($name, 'baby') || str_contains($name, 'seat')          => new BabySeatAddOn($rental, $addon),
            default                                                               => new GPSAddOn($rental, $addon),
        };
    }
}
