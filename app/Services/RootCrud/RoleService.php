<?php

namespace App\Services\RootCrud;

use App\Models\Role;
use App\Repositories\Contracts\RoleRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class RoleService
{
    public function __construct(private readonly RoleRepositoryInterface $roleRepository) {}

    public function all()
    {
        return $this->roleRepository->all();
    }

    public function create(array $data): Role
    {
        return $this->roleRepository->create($data);
    }

    public function delete($id): void
    {
        $role = $this->roleRepository->findById($id);

        if (! $role) {
            throw (new ModelNotFoundException)->setModel(Role::class, [$id]);
        }

        $this->roleRepository->delete($role);
    }
}
