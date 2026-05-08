<?php

namespace App\Repositories;

use App\Models\Car;
use App\Models\Payment;
use App\Models\Penalty;
use App\Repositories\Contracts\DendaRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class DendaRepository implements DendaRepositoryInterface
{
    public function paginate(int $perPage = 10): LengthAwarePaginator
    {
        return Penalty::query()
            ->with(['payments.order.car'])
            ->orderByDesc('id')
            ->paginate($perPage)
            ->withQueryString();
    }

    public function getFormOptions(): array
    {
        return [
            'cars' => Car::query()->orderBy('name')->get(['series_number', 'name']),
            'payments' => Payment::query()
                ->with(['order.car'])
                ->orderByDesc('id')
                ->get(['id', 'Order_id', 'total_price', 'status']),
        ];
    }

    public function create(array $penaltyData, int $paymentId): Penalty
    {
        return DB::transaction(function () use ($penaltyData, $paymentId) {
            $penalty = Penalty::query()->create($penaltyData);
            $penalty->payments()->attach($paymentId);

            return $penalty->load(['payments.order.car']);
        });
    }

    public function findById(int $id): ?Penalty
    {
        return Penalty::query()->with(['payments.order.car'])->find($id);
    }

    public function update(Penalty $penalty, array $penaltyData, int $paymentId): Penalty
    {
        return DB::transaction(function () use ($penalty, $penaltyData, $paymentId) {
            $penalty->update($penaltyData);
            $penalty->payments()->sync([$paymentId]);

            return $penalty->refresh()->load(['payments.order.car']);
        });
    }

    public function delete(Penalty $penalty): void
    {
        DB::transaction(function () use ($penalty) {
            $penalty->payments()->detach();
            $penalty->delete();
        });
    }

    public function paymentBelongsToCar(int $paymentId, string $carSeriesNumber): bool
    {
        return Payment::query()
            ->whereKey($paymentId)
            ->whereHas('order', fn ($query) => $query->where('Car_series_number', $carSeriesNumber))
            ->exists();
    }
}
