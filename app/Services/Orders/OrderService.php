<?php

namespace App\Services\Orders;

use App\Exceptions\BookingNotFoundException;
use App\Orders\Filters\LatestOrderSortFilter;
use App\Orders\Filters\StatusFilter;
use App\Repositories\Contracts\OrderRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class OrderService
{
    public function __construct(private readonly OrderRepositoryInterface $orderRepository) {}

    public function getBookingsWithPagination(array $filters): LengthAwarePaginator
    {
        $perPage = $this->resolvePerPage($filters['per_page'] ?? 10);

        return $this->orderRepository->paginateWithFilters(
            $filters,
            $this->getQueryFilters(),
            $perPage
        );
    }

    public function getBookingDetail(string $bookingId): object
    {
        $booking = $this->orderRepository->findById($bookingId);

        if (! $booking) {
            throw BookingNotFoundException::forId($bookingId);
        }

        return $booking;
    }

    public function deleteBooking(string $bookingId): void
    {
        $this->getBookingDetail($bookingId);
        $this->orderRepository->delete($bookingId);
    }

    public function updateBooking(string $bookingId, array $data): object
    {
        $booking = $this->getBookingDetail($bookingId);

        return $this->orderRepository->update($booking, $data);
    }

    public function approveBooking(string $bookingId): object
    {
        $booking = $this->getBookingDetail($bookingId);

        $this->orderRepository->update($booking, ['status' => 'aktif']);

        // Auto-create Payment record only if it doesn't exist
        if ($booking->payments()->count() === 0) {
            \App\Models\Payment::create([
                'id'          => 'PAY-' . now()->format('ymd') . '-' . \Illuminate\Support\Str::upper(\Illuminate\Support\Str::random(4)),
                'method'      => 'pending',
                'status'      => 'unpaid',
                'total_price' => null,
                'Order_id'    => $booking->id,
            ]);
        }

        return $booking->refresh();
    }

    public function rejectBooking(string $bookingId, string $reason = ''): object
    {
        $booking = $this->getBookingDetail($bookingId);

        $this->orderRepository->update($booking, ['status' => 'ditolak']);

        return $booking->refresh();
    }

    private function resolvePerPage(mixed $perPage): int
    {
        return min(max((int) $perPage, 5), 50);
    }

    private function getQueryFilters(): array
    {
        return [
            new StatusFilter,
            new LatestOrderSortFilter,
        ];
    }
}
