<?php

namespace App\Repositories;

use App\Repositories\Repository;

class ResourceRepository extends Repository
{

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\Resources::class;
    }
}
