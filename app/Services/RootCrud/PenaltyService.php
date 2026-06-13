<?php

namespace App\Services\RootCrud;

use App\Models\Penalty;
use App\Repositories\Contracts\PenaltyRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PenaltyService
{
    public function __construct(private readonly PenaltyRepositoryInterface $penaltyRepository) {}

    public function all()
    {
        return $this->penaltyRepository->all();
    }

    public function create(array $data): Penalty
    {
        return $this->penaltyRepository->create($data);
    }

    public function getById($id): Penalty
    {
        $penalty = $this->penaltyRepository->findById($id);

        if (! $penalty) {
            throw (new ModelNotFoundException)->setModel(Penalty::class, [$id]);
        }

        return $penalty;
    }

    public function update($id, array $data): Penalty
    {
        return $this->penaltyRepository->update($this->getById($id), $data);
    }

    public function delete($id): void
    {
        $this->penaltyRepository->delete($this->getById($id));
    }
}
