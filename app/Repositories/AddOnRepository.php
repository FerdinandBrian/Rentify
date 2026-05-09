<?php

namespace App\Repositories;

use App\Models\Addon;
use App\Repositories\Contracts\AddOnRepositoryInterface;

class AddOnRepository extends BaseRepository implements AddOnRepositoryInterface
{
    /**
     * AddOnRepository constructor.
     *
     * @param Addon $addon
     */
    public function __construct(Addon $addon)
    {
        parent::__construct($addon);
    }
}
