<?php

namespace App\Services\User;

use App\Models\Car;
use App\Models\User;
use Carbon\Carbon;

class UserOrderBuilder
{
    private array $data = [];

    public function forUser(User $user): self
    {
        $this->data['name'] = $user->name;
        $this->data['call_number'] = $user->call_number ?? '-';
        $this->data['email'] = $user->email;
        $this->data['User_id'] = $user->id;

        return $this;
    }

    public function forCar(Car $car): self
    {
        $this->data['Car_series_number'] = $car->series_number;

        return $this;
    }

    public function withRentalPeriod(string $startDate, string $endDate): self
    {
        $this->data['start_rent'] = Carbon::parse($startDate)->startOfDay();
        $this->data['end_rent'] = Carbon::parse($endDate)->endOfDay();

        return $this;
    }

    public function withStatus(string $status): self
    {
        $this->data['status'] = $status;

        return $this;
    }

    public function withId(string $id): self
    {
        $this->data['id'] = $id;

        return $this;
    }

    public function build(): array
    {
        return $this->data;
    }
}
