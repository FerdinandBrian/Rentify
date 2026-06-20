<?php

namespace Tests\Unit;

use App\Models\Car;
use App\Models\User;
use App\Services\User\UserOrderBuilder;
use Tests\TestCase;

class UserOrderBuilderTest extends TestCase
{
    public function test_build_succeeds_when_all_required_fields_are_set(): void
    {
        $user = new User();
        $user->id = 1;
        $user->name = 'John Doe';
        $user->email = 'john@example.com';
        $user->call_number = '08123456789';

        $car = new Car();
        $car->series_number = 'SERIES123';

        $builder = new UserOrderBuilder();
        $data = $builder
            ->forUser($user)
            ->forCar($car)
            ->withRentalPeriod('2026-06-19', '2026-06-20')
            ->build();

        $this->assertEquals(1, $data['User_id']);
        $this->assertEquals('John Doe', $data['name']);
        $this->assertEquals('john@example.com', $data['email']);
        $this->assertEquals('SERIES123', $data['Car_series_number']);
        $this->assertEquals('2026-06-19 00:00:00', $data['start_rent']->toDateTimeString());
        $this->assertEquals('2026-06-20 23:59:59', $data['end_rent']->toDateTimeString());
    }

    public function test_build_throws_exception_when_user_is_missing(): void
    {
        $car = new Car();
        $car->series_number = 'SERIES123';

        $builder = new UserOrderBuilder();

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('User must be set.');

        $builder
            ->forCar($car)
            ->withRentalPeriod('2026-06-19', '2026-06-20')
            ->build();
    }

    public function test_build_throws_exception_when_car_is_missing(): void
    {
        $user = new User();
        $user->id = 1;
        $user->name = 'John Doe';
        $user->email = 'john@example.com';

        $builder = new UserOrderBuilder();

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Car must be set.');

        $builder
            ->forUser($user)
            ->withRentalPeriod('2026-06-19', '2026-06-20')
            ->build();
    }

    public function test_build_throws_exception_when_period_is_missing(): void
    {
        $user = new User();
        $user->id = 1;
        $user->name = 'John Doe';
        $user->email = 'john@example.com';

        $car = new Car();
        $car->series_number = 'SERIES123';

        $builder = new UserOrderBuilder();

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Rental period must be set.');

        $builder
            ->forUser($user)
            ->forCar($car)
            ->build();
    }
}
