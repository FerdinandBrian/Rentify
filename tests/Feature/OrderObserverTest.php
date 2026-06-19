<?php

namespace Tests\Feature;

use App\Models\Brand;
use App\Models\Car;
use App\Models\Order;
use App\Models\Role;
use App\Models\User;
use App\Notifications\OrderStatusChangedNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class OrderObserverTest extends TestCase
{
    use RefreshDatabase;

    public function test_order_status_change_sends_notification(): void
    {
        Notification::fake();

        $role = Role::firstOrCreate(['id' => 3], ['name' => 'User']);
        $user = User::factory()->create(['role_id' => $role->id]);

        $brand = Brand::firstOrCreate(['id' => 1], ['name' => 'Toyota']);
        
        $car = Car::create([
            'series_number' => 'SERIES' . rand(100, 999),
            'name' => 'Test Car',
            'price' => 100000,
            'type' => 'SUV',
            'year' => now(),
            'status' => 'Tersedia',
            'brand_id' => $brand->id,
        ]);

        $order = Order::create([
            'id' => 'ORD-TEST-' . rand(100, 999),
            'name' => $user->name,
            'call_number' => '0812345678',
            'email' => $user->email,
            'status' => 'menunggu',
            'start_rent' => now(),
            'end_rent' => now()->addDays(2),
            'Car_series_number' => $car->series_number,
            'User_id' => $user->id,
        ]);

        // Change status to trigger the observer
        $order->status = 'aktif';
        $order->save();

        Notification::assertSentTo($user, OrderStatusChangedNotification::class, function ($notification) use ($order) {
            return $notification->via($order->user) === ['mail'];
        });
    }

    public function test_car_availability_observer_sets_car_to_available_when_order_cancelled(): void
    {
        $role = Role::firstOrCreate(['id' => 3], ['name' => 'User']);
        $user = User::factory()->create(['role_id' => $role->id]);

        $brand = Brand::firstOrCreate(['id' => 1], ['name' => 'Toyota']);

        $car = Car::create([
            'series_number' => 'SERIES' . rand(100, 999),
            'name' => 'Test Car',
            'price' => 100000,
            'type' => 'SUV',
            'year' => now(),
            'status' => 'Tidak Tersedia',
            'brand_id' => $brand->id,
        ]);

        $order = Order::create([
            'id' => 'ORD-TEST-' . rand(100, 999),
            'name' => $user->name,
            'call_number' => '0812345678',
            'email' => $user->email,
            'status' => 'menunggu',
            'start_rent' => now(),
            'end_rent' => now()->addDays(2),
            'Car_series_number' => $car->series_number,
            'User_id' => $user->id,
        ]);

        // Cancel order to trigger the CarAvailabilityObserver
        $order->status = 'dibatalkan';
        $order->save();

        $this->assertEquals('tersedia', $car->fresh()->status);
    }
}
