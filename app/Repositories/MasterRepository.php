<?php
namespace App\Repositories;

use App\Repositories\Repository;
use Illuminate\Support\Facades\DB;

class MasterRepository extends Repository
{

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\Master::class;
    }

    public function getAllMaster($table_name)
    {
        $table = str_replace("-","_",$table_name);
        $tableName = 'master_' . $table;
        return DB::table($tableName)->select('id', 'name')->get();
    }

    public function getRoles()
    {
        // $table = str_replace("-","_",$table_name);
        $tableName = 'role';
        return DB::table($tableName)->select('id', 'name')->get();
    }
}
