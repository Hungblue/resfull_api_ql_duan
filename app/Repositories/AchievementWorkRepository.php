<?php

namespace App\Repositories;

use App\Repositories\Repository;
use App\Models\AchievementWork;
use App\Models\User;
use Auth;
use App\Models\Project;

class AchievementWorkRepository extends Repository
{

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return AchievementWork::class;
    }
    public function getAllAchievementWork($param)
    {
        $dataAchievementWork = AchievementWork::where('check_point_id',$param['check_point_id'])
        ->leftjoin('projects','projects.id','achievement_work.project_id')
       
        ->select('achievement_work.*','projects.name')
        ->orderBy('achievement_work.created_at', 'desc')
        ->paginate(isset($param['pageSize']) ? $param['pageSize'] : 15);
        return [
            'status' => true,
            'message' => 'Lấy danh sách thành công',
            'data' => $dataAchievementWork->items(),
            'pages'=>[
                'totalElements'      =>$dataAchievementWork->total(),
                'numberItemPerPage'    =>$dataAchievementWork->perPage(),
                'currentPage'=>$dataAchievementWork->currentPage()
            ]
        ];
    }
    public function detailAchievementWork($id)
    {
        $detailAchievementWork = AchievementWork::where('achievement_work.id',$id)
        ->leftjoin('projects','projects.id','achievement_work.project_id')
        ->select('achievement_work.*','projects.name')
        ->first();
        if($detailAchievementWork){
            $message = [
                'status' => true,
                'message' => 'Lấy dữ liệu thành công',
                'data' =>$detailAchievementWork,
            ];
        } else {
            $message = [
                'status' => false,
                'message' => 'Dữ liệu không tồn tại',
            ];
        }
        return  $message;
    }
}
