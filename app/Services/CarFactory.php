<?php

namespace App\Services;

use App\Models\Car;
use App\Repositories\Contracts\BrandRepositoryInterface;
use Illuminate\Support\Facades\Log;

class CarFactory
{
    protected $brandRepository;

    public function __construct(BrandRepositoryInterface $brandRepository)
    {
        $this->brandRepository = $brandRepository;
    }

    public function createCar(array $data): Car
    {
        $data['transmission'] = $data['transmission'] ?? 'manual';
        $data['status'] = $data['status'] ?? 'Tersedia';
        $data['capacity'] = $data['capacity'] ?? $this->defaultCapacityForType($data['type'] ?? '');
        
        $brand = $this->brandRepository->findById($data['Brand_id'] ?? 0);
        if ($brand && strtolower($brand->name) === 'tesla') {
            $data['is_electric'] = true;
        } else {
            $data['is_electric'] = $data['is_electric'] ?? false;
        }

        if (($data['price'] ?? 0) < 100000) {
            throw new \InvalidArgumentException('Harga minimal adalah 100.000');
        }

        return Car::create($data);
    }

    public function updateCar(Car $car, array $data): Car
    {
        if (isset($data['price']) && $car->price > 0) {
            $kenaikan = ($data['price'] - $car->price) / $car->price * 100;
            if ($kenaikan > 20) {
                Log::warning('Kenaikan harga lebih dari 20%', [
                    'car_id' => $car->id,
                    'old_price' => $car->price,
                    'new_price' => $data['price'],
                    'percentage' => $kenaikan
                ]);
            }
        }

        $car->update($data);
        return $car->fresh();
    }

    protected function defaultCapacityForType(string $type): int
    {
        return match ($type) {
            'suv' => 7,
            'mpv' => 7,
            'sedan' => 5,
            'truk' => 3,
            default => 4,
        };
    }
}