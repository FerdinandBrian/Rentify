<?php

namespace App\Repositories;

use App\Models\Penalty;
use App\Repositories\Contracts\PenaltyRepositoryInterface;

class PenaltyRepository extends BaseRepository implements PenaltyRepositoryInterface
{
    public function __construct(Penalty $penalty)
    {
        parent::__construct($penalty);
    }
}
