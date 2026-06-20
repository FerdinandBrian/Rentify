<?php

namespace App\Services\RootCrud;

use App\Models\Addon;
use App\Repositories\Contracts\AddOnRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AddonService
{
    public function __construct(private readonly AddOnRepositoryInterface $addonRepository) {}

    public function all()
    {
        return $this->addonRepository->all();
    }

    public function create(array $data): Addon
    {
        return $this->addonRepository->create($this->normalizePayload($data));
    }

    public function getById($id): Addon
    {
        $addon = $this->addonRepository->findById($id);

        if (! $addon) {
            throw (new ModelNotFoundException)->setModel(Addon::class, [$id]);
        }

        return $addon;
    }

    public function update($id, array $data): Addon
    {
        return $this->addonRepository->update(
            $this->getById($id),
            $this->normalizePayload($data)
        );
    }

    public function delete($id): void
    {
        $this->addonRepository->delete($this->getById($id));
    }

    private function normalizePayload(array $data): array
    {
        if (array_key_exists('price', $data)) {
            $data['price_per_unit'] = $data['price'];
            unset($data['price']);
        }

        unset($data['id']);

        return $data;
    }
}
