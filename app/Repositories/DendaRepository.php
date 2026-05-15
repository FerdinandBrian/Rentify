<?php

namespace App\Repositories;

use App\Models\Car;
use App\Models\Payment;
use App\Models\Penalty;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\DendaRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class DendaRepository extends BaseRepository implements DendaRepositoryInterface
{
    public function __construct(Penalty $penalty)
    {
        parent::__construct($penalty);
    }

    public function paginate(int $perPage = 10): LengthAwarePaginator
    {
        return $this->model->newQuery()
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

    public function createWithPayment(array $penaltyData, int $paymentId): Penalty
    {
        return DB::transaction(function () use ($penaltyData, $paymentId) {
            $penalty = $this->model->newQuery()->create($penaltyData);
            $penalty->payments()->attach($paymentId);

            return $penalty->load(['payments.order.car']);
        });
    }

    public function findById($id): ?Penalty
    {
        return $this->model->newQuery()->with(['payments.order.car'])->find($id);
    }

    public function updateWithPayment(Penalty $penalty, array $penaltyData, int $paymentId): Penalty
    {
        return DB::transaction(function () use ($penalty, $penaltyData, $paymentId) {
            $penalty->update($penaltyData);
            $penalty->payments()->sync([$paymentId]);

            return $penalty->refresh()->load(['payments.order.car']);
        });
    }

    public function delete($model): void
    {
        if (!($model instanceof Penalty)) {
            $model = $this->findById($model);
        }

        if (!$model) {
            return;
        }

        DB::transaction(function () use ($model) {
            $model->payments()->detach();
            $model->delete();
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
