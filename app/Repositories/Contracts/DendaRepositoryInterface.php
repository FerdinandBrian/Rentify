<?php

namespace App\Repositories\Contracts;

use App\Models\Penalty;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface DendaRepositoryInterface extends BaseRepositoryInterface
{
    public function getFormOptions(): array;

    public function createWithPayment(array $penaltyData, int $paymentId): Penalty;

    public function updateWithPayment(Penalty $penalty, array $penaltyData, int $paymentId): Penalty;

    public function paymentBelongsToCar(int $paymentId, string $carSeriesNumber): bool;
}
