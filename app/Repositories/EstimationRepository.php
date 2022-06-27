<?php
namespace App\Repositories;

use App\Repositories\Repository;

class EstimationRepository extends Repository
{

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\Estimations::class;
    }

}
