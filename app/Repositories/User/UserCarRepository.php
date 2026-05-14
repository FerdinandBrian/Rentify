<?php

namespace App\Repositories\User;

use App\Models\Brand;
use App\Models\Car;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class UserCarRepository
{
    public function paginateAvailableCars(array $filters, array $strategies, int $perPage = 12): LengthAwarePaginator
    {
        $query = Car::query()
            ->with(['brand', 'images'])
            ->whereIn('status', ['tersedia', 'available', 'Tersedia']);

        foreach ($strategies as $strategy) {
            $query = $strategy->apply($query, $filters);
        }

        return $query->orderBy('name')->paginate($perPage)->withQueryString();
    }

    public function findWithBrand(string $seriesNumber): Car
    {
        return Car::query()
            ->with(['brand', 'images'])
            ->findOrFail($seriesNumber);
    }

    public function relatedCars(Car $car, int $limit = 4): Collection
    {
        return Car::query()
            ->with(['brand', 'images'])
            ->where('brand_id', $car->brand_id)
            ->where($car->getKeyName(), '!=', $car->getKey())
            ->whereIn('status', ['tersedia', 'available', 'Tersedia'])
            ->limit($limit)
            ->get();
    }

    public function brands(): Collection
    {
        return Brand::query()->orderBy('name')->get();
    }

    public function types(): \Illuminate\Support\Collection
    {
        return Car::query()
            ->select('type')
            ->distinct()
            ->orderBy('type')
            ->pluck('type');
    }

    public function availableCarsCount(): int
    {
        return Car::query()
            ->whereIn('status', ['tersedia', 'available', 'Tersedia'])
            ->count();
    }
}
