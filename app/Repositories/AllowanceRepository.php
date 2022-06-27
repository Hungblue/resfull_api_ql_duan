<?php

namespace App\Repositories;

use App\Models\Allowance;
use App\Repositories\Repository;

class AllowanceRepository extends Repository
{

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return Allowance::class;
    }
}
