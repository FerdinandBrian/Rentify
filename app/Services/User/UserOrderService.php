<?php

namespace App\Services\User;

use App\Exceptions\DocumentNotVerifiedException;
use App\Models\Car;
use App\Models\Order;
use App\Models\User;
use App\Orders\Filters\LatestOrderSortFilter;
use App\Orders\Filters\StatusFilter;
use App\Repositories\Contracts\AddOnRepositoryInterface;
use App\Repositories\Contracts\OrderRepositoryInterface;
use App\Repositories\User\UserCarRepository;
use App\Repositories\User\UserDocumentRepository;
use App\Repositories\User\UserOrderRepository;
use App\Services\Rental\RentalBuilderService;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;

class UserOrderService
{
    private const STATUS_FILTERS = [
        'menunggu'   => ['menunggu', 'pending'],
        'aktif'      => ['aktif', 'active'],
        'selesai'    => ['selesai', 'completed'],
        'dibatalkan' => ['dibatalkan', 'cancelled', 'canceled'],
    ];

    public function __construct(
        private readonly UserCarRepository      $carRepository,
        private readonly UserOrderRepository    $orderRepository,
        private readonly UserDocumentRepository $documentRepository,
        private readonly AddOnRepositoryInterface $addonRepository,
        private readonly RentalBuilderService   $rentalBuilder,
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

    /**
     * Buat order dengan status 'menunggu' sekaligus menghitung estimasi biaya
     * menggunakan Decorator Pattern untuk addon yang dipilih user.
     *
     * @param  User        $user
     * @param  Car         $car
     * @param  string      $startDate
     * @param  string      $endDate
     * @param  int[]       $addonIds   ID addon yang dipilih (boleh kosong)
     * @return array{order: Order, estimated_cost: float, rental_description: string}
     */
    public function createPendingOrder(User $user, Car $car, string $startDate, string $endDate, array $addonIds = []): array
    {
        $builder = new UserOrderBuilder;

        $orderData = $builder
            ->withId($this->generateOrderId())
            ->forUser($user)
            ->forCar($car)
            ->withRentalPeriod($startDate, $endDate)
            ->withStatus('menunggu')
            ->build();

        $order = $this->orderRepository->create($orderData);

        // Hitung estimasi biaya menggunakan Decorator Pattern
        $days   = (int) Carbon::parse($startDate)->startOfDay()->diffInDays(Carbon::parse($endDate)->startOfDay()) + 1;
        $addons = array_filter(
            array_map(fn (int $id) => $this->addonRepository->findById($id), $addonIds)
        );

        $rental = $this->rentalBuilder->build($car, $days, $addons);

        // Auto-create Payment record so addons and prices can be stored immediately
        $payment = \App\Models\Payment::create([
            'method'      => 'pending',
            'status'      => 'unpaid',
            'total_price' => $rental->getCost(),
            'Order_id'    => $order->id,
        ]);

        foreach ($addons as $addon) {
            $name = strtolower($addon->name);
            $addonCost = 0;
            if (str_contains($name, 'driver')) {
                $addonCost = ($addon->price_per_day ?? 0) * $days;
            } else {
                $addonCost = $addon->price_per_unit ?? 0;
            }
            
            $payment->addons()->attach($addon->id, ['total_price' => $addonCost]);
        }

        return [
            'order'               => $order,
            'estimated_cost'      => $rental->getCost(),
            'rental_description'  => $rental->getDescription(),
        ];
    }

    /**
     * Validasi dokumen & ketersediaan mobil, lalu delegasikan ke createPendingOrder().
     *
     * @param  User   $user
     * @param  string $carSeriesNumber
     * @param  string $startDate
     * @param  string $endDate
     * @param  int[]  $addonIds
     * @return array{order: Order, estimated_cost: float, rental_description: string}|null
     */
    public function createPendingOrderForCarSeries(
        User   $user,
        string $carSeriesNumber,
        string $startDate,
        string $endDate,
        array  $addonIds = []
    ): ?array {
        if ($this->documentRepository->approvedCountForUser($user->id) === 0) {
            throw DocumentNotVerifiedException::forUser();
        }

        $car = $this->carRepository->findWithBrand($carSeriesNumber);

        if (! $this->isCarAvailable($car, $startDate, $endDate)) {
            return null;
        }

        return $this->createPendingOrder($user, $car, $startDate, $endDate, $addonIds);
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

