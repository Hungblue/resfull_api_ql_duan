<?php

namespace App\Repositories;

use App\Models\ContractType;
use App\Repositories\Repository;

class ContractTypeRepository extends Repository
{

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return ContractType::class;
    }
}
