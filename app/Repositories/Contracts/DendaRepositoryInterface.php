<?php

namespace App\Repositories\Contracts;

use App\Models\Penalty;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface DendaRepositoryInterface
{
    public function paginate(int $perPage = 10): LengthAwarePaginator;

    public function getFormOptions(): array;

    public function create(array $penaltyData, int $paymentId): Penalty;

    public function findById(int $id): ?Penalty;

    public function update(Penalty $penalty, array $penaltyData, int $paymentId): Penalty;

    public function delete(Penalty $penalty): void;

    public function paymentBelongsToCar(int $paymentId, string $carSeriesNumber): bool;
}
