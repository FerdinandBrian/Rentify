<?php

namespace App\Services\Denda;

use App\Models\Penalty;
use App\Repositories\Contracts\DendaRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use InvalidArgumentException;

class DendaService
{
    public function __construct(private readonly DendaRepositoryInterface $dendaRepository) {}

    public function getDendaWithPagination(int $perPage = 10): LengthAwarePaginator
    {
        return $this->dendaRepository->paginate($perPage);
    }

    public function getDendaFormOptions(): array
    {
        return $this->dendaRepository->getFormOptions();
    }

    public function getDendaDetail(int $id): Penalty
    {
        return $this->getDendaOrFail($id);
    }

    public function createDenda(array $data): Penalty
    {
        $this->validatePaymentMatchesCar((int) $data['payment_id'], $data['car_series_number']);

        return $this->dendaRepository->createWithPayment(
            $this->onlyPenaltyData($data),
            (int) $data['payment_id']
        );
    }

    public function updateDenda(int $id, array $data): Penalty
    {
        $penalty = $this->getDendaOrFail($id);
        $this->validatePaymentMatchesCar((int) $data['payment_id'], $data['car_series_number']);

        return $this->dendaRepository->updateWithPayment(
            $penalty,
            $this->onlyPenaltyData($data),
            (int) $data['payment_id']
        );
    }

    public function deleteDenda(int $id): void
    {
        $this->dendaRepository->delete($this->getDendaOrFail($id));
    }

    private function getDendaOrFail(int $id): Penalty
    {
        $penalty = $this->dendaRepository->findById($id);

        if (! $penalty) {
            throw new InvalidArgumentException("Denda dengan ID {$id} tidak ditemukan.");
        }

        return $penalty;
    }

    private function validatePaymentMatchesCar(int $paymentId, string $carSeriesNumber): void
    {
        if (! $this->dendaRepository->paymentBelongsToCar($paymentId, $carSeriesNumber)) {
            throw new InvalidArgumentException('Payment yang dipilih tidak sesuai dengan ID mobil tersebut.');
        }
    }

    private function onlyPenaltyData(array $data): array
    {
        return [
            'type' => $data['type'],
            'total_penalty' => $data['total_penalty'],
        ];
    }
}
