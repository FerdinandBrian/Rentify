<?php

namespace App\Services\User;

use App\Models\Car;
use App\Models\Order;
use App\Models\User;
use App\Exceptions\DocumentNotVerifiedException;
use App\Repositories\User\UserCarRepository;
use App\Repositories\User\UserDocumentRepository;
use App\Repositories\User\UserOrderRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;

class UserOrderService
{
    private const STATUS_FILTERS = [
        'menunggu' => ['menunggu', 'pending'],
        'aktif' => ['aktif', 'active'],
        'selesai' => ['selesai', 'completed'],
        'dibatalkan' => ['dibatalkan', 'cancelled', 'canceled'],
    ];

    public function __construct(
        private readonly UserCarRepository $carRepository,
        private readonly UserOrderRepository $orderRepository,
        private readonly UserDocumentRepository $documentRepository
    ) {}

    public function paginatedOrdersFor(User $user, ?string $status): LengthAwarePaginator
    {
        return $this->orderRepository->paginateForUser(
            $user->id,
            $status ? (self::STATUS_FILTERS[$status] ?? [$status]) : null
        );
    }

    public function statusFilters(): array
    {
        return self::STATUS_FILTERS;
    }

    public function orderDetailFor(User $user, string $orderId): Order
    {
        return $this->orderRepository->findForUser($orderId, $user->id);
    }

    public function createPendingOrder(User $user, Car $car, string $startDate, string $endDate): Order
    {
        $builder = new UserOrderBuilder;

        $orderData = $builder
            ->withId($this->generateOrderId())
            ->forUser($user)
            ->forCar($car)
            ->withRentalPeriod($startDate, $endDate)
            ->withStatus('menunggu')
            ->build();

        return $this->orderRepository->create($orderData);
    }

    public function createPendingOrderForCarSeries(User $user, string $carSeriesNumber, string $startDate, string $endDate): ?Order
    {
        if ($this->documentRepository->approvedCountForUser($user->id) === 0) {
            throw DocumentNotVerifiedException::forUser();
        }

        $car = $this->carRepository->findWithBrand($carSeriesNumber);

        if (! $this->isCarAvailable($car, $startDate, $endDate)) {
            return null;
        }

        return $this->createPendingOrder($user, $car, $startDate, $endDate);
    }

    public function cancelPendingOrder(User $user, string $orderId): Order
    {
        $order = $this->orderRepository->findForUser($orderId, $user->id);

        abort_unless(in_array($order->status, ['menunggu', 'pending'], true), 404);

        return $this->orderRepository->cancel($order);
    }

    public function isCarAvailable(Car $car, string $startDate, string $endDate): bool
    {
        if (! in_array(strtolower($car->status), ['tersedia', 'available'], true)) {
            return false;
        }

        return ! $this->orderRepository->hasOverlappingBooking($car->series_number, $startDate, $endDate);
    }

    public function hasApprovedDocument(User $user): bool
    {
        return $this->documentRepository->approvedCountForUser($user->id) > 0;
    }

    private function generateOrderId(): string
    {
        do {
            $id = 'ORD-' . now()->format('ymd') . '-' . Str::upper(Str::random(4));
        } while ($this->orderRepository->exists($id));

        return $id;
    }
}
