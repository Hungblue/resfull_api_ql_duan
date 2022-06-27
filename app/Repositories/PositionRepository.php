<?php

namespace App\Repositories;

use App\Models\Position;
use App\Repositories\Repository;

class PositionRepository extends Repository
{

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return Position::class;
    }
}
