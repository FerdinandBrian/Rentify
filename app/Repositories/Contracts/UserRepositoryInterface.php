<?php

namespace App\Repositories\Contracts;

interface UserRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Get all users with the customer role (role_id = 3).
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getCustomers();
}
