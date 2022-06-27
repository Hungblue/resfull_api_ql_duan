<?php

namespace App\Repositories;

use App\Repositories\Repository;

class EmailRemindRepository extends Repository
{
    //
    public function getModel()
    {
        return \App\Models\EmailRemind::class;
    }
}
