<?php

namespace App\Repositories;

use App\Repositories\Repository;
use App\Models\User;
use Auth;
use App\Models\Kills;

class NewSkillRepository extends Repository
{

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return Kills::class;
    }
    public function getAllNewKill($param)
    {
        $dataNewKill = Kills::where('check_point_id',$param['check_point_id'])
        ->leftjoin('master_type_skill','master_type_skill.id','skills.type_skill_id')
        ->leftjoin('master_level_skill','master_level_skill.id','skills.level_id')
        ->select('skills.*','master_type_skill.name_type_skill','master_level_skill.name_level')
        ->orderBy('skills.created_at', 'desc')
        ->paginate(isset($param['pageSize']) ? $param['pageSize'] : 15);
        return [
            'status' => true,
            'message' => 'Lấy danh sách thành công',
            'data' => $dataNewKill->items(),
            'pages'=>[
                'totalElements'      =>$dataNewKill->total(),
                'numberItemPerPage'    =>$dataNewKill->perPage(),
                'currentPage'=>$dataNewKill->currentPage()
            ]
        ];
    }
    public function detailNewKill($id)
    {
        $detailNewKill = Kills::where('skills.id',$id)
        ->leftjoin('master_type_skill','master_type_skill.id','skills.type_skill_id')
        ->leftjoin('master_level_skill','master_level_skill.id','skills.level_id')
        ->select('skills.*','master_type_skill.name_type_skill','master_level_skill.name_level')
        ->first();
        if($detailNewKill){
            $message = [
                'status' => true,
                'message' => 'Lấy dữ liệu thành công',
                'data' =>$detailNewKill,
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
