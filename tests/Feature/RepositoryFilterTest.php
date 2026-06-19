<?php

namespace Tests\Feature;

use App\Models\Brand;
use App\Models\Car;
use App\Models\Order;
use App\Models\Role;
use App\Models\User;
use App\Repositories\CarRepository;
use App\Repositories\OrderRepository;
use App\Orders\Filters\StatusFilter;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RepositoryFilterTest extends TestCase
{
    use RefreshDatabase;

    public function test_order_repository_paginates_with_filters(): void
    {
        $role = Role::firstOrCreate(['id' => 3], ['name' => 'User']);
        $user = User::factory()->create(['role_id' => $role->id]);

        $brand = Brand::firstOrCreate(['id' => 1], ['name' => 'Toyota']);

        $car = Car::create([
            'series_number' => 'SERIES1',
            'name' => 'Toyota Avanza',
            'price' => 100000,
            'type' => 'MPV',
            'year' => now(),
            'status' => 'Tersedia',
            'brand_id' => $brand->id,
        ]);

        $orderActive = Order::create([
            'id' => 'ORD-1',
            'name' => $user->name,
            'call_number' => '0812345678',
            'email' => $user->email,
            'status' => 'aktif',
            'start_rent' => now(),
            'end_rent' => now()->addDays(2),
            'Car_series_number' => $car->series_number,
            'User_id' => $user->id,
        ]);

        $orderPending = Order::create([
            'id' => 'ORD-2',
            'name' => $user->name,
            'call_number' => '0812345678',
            'email' => $user->email,
            'status' => 'menunggu',
            'start_rent' => now(),
            'end_rent' => now()->addDays(2),
            'Car_series_number' => $car->series_number,
            'User_id' => $user->id,
        ]);

        $orderRepo = new OrderRepository(new Order());
        
        $paginator = $orderRepo->paginateWithFilters(
            ['status' => 'aktif'],
            [new StatusFilter()],
            10
        );

        $this->assertCount(1, $paginator->items());
        $this->assertEquals('ORD-1', $paginator->items()[0]->id);
    }

    public function test_car_repository_filters_with_brands_using_strategy(): void
    {
        $brandToyota = Brand::firstOrCreate(['id' => 1], ['name' => 'Toyota']);
        $brandHonda = Brand::firstOrCreate(['id' => 2], ['name' => 'Honda']);

        Car::create([
            'series_number' => 'SERIES1',
            'name' => 'Toyota Avanza',
            'price' => 100000,
            'type' => 'MPV',
            'year' => now(),
            'status' => 'Tersedia',
            'brand_id' => $brandToyota->id,
        ]);

        Car::create([
            'series_number' => 'SERIES2',
            'name' => 'Honda Civic',
            'price' => 200000,
            'type' => 'Sedan',
            'year' => now(),
            'status' => 'Tersedia',
            'brand_id' => $brandHonda->id,
        ]);

        $carRepo = new CarRepository(new Car());

        // Test filter by brand_id
        $filteredToyota = $carRepo->getFilteredWithBrands(['brand_id' => $brandToyota->id]);
        $this->assertCount(1, $filteredToyota);
        $this->assertEquals('Toyota Avanza', $filteredToyota->first()->name);

        // Test filter by type
        $filteredSedan = $carRepo->getFilteredWithBrands(['type' => 'Sedan']);
        $this->assertCount(1, $filteredSedan);
        $this->assertEquals('Honda Civic', $filteredSedan->first()->name);
    }
}
