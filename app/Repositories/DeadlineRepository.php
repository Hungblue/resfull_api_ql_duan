<?php
namespace App\Repositories;

use App\Repositories\Repository;

class DeadlineRepository extends Repository
{

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\Deadlines::class;
    }

    public function getAllDeadlines()
    {
        try {
            $deadlines = $this->getAll();
            foreach($deadlines as $deadline){
                $item = clone $deadline;
                // dd($deadline->projects->code);
                // $project = $deadline->projects;
                $deadline->project_code = $item->projects ? $item->projects->code : '';
                // echo "<pre>";
                // var_dump($deadline->projects);
                // ECHO "</pre>";
            }
            return $deadlines;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

}
