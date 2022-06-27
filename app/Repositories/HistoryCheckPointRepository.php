<?php

namespace App\Repositories;

use App\Repositories\Repository;
use App\Models\CheckPoint;
use App\Models\User;
use Auth,DB;
use App\Models\HistoryCheckPoint;
use App\Models\Contract;
use App\Models\Kills;
use App\Models\AchievementWork;

class HistoryCheckPointRepository extends Repository
{

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return HistoryCheckPoint::class;
    }
    public function createHistoryCheckPoint($data)
    {
        $check_history = HistoryCheckPoint::where('check_point_id',$data['check_point_id'])
        ->where('user_id',$data['user_id'])->first();
        $check_history_user_point = HistoryCheckPoint::where('user_id',$data['user_id'])->orderBy('created_at', 'desc')->first();
        $check_point = Contract::where('user_id',$data['user_id'])
        ->orderBy('created_at', 'desc')->first();
        if (!$check_history) {
            $historyCheckPoint = new HistoryCheckPoint();
            $historyCheckPoint->check_point_id = $data['check_point_id'];
            $historyCheckPoint->user_id = $data['user_id'];
            $historyCheckPoint->status =  $data['status'];
            $historyCheckPoint->contract_id = $check_point ?  $check_point->id : 0;
            if($check_history_user_point){
                $historyCheckPoint->current_salary = $check_history_user_point->new_salary ? $check_history_user_point->new_salary :  $check_history_user_point->current_salary;
            } else if($check_point) {
                $historyCheckPoint->current_salary = $check_point->salary;
            } else {
                $historyCheckPoint->current_salary = '';
            }
            if (isset($data['content'])) {
                $historyCheckPoint->content = $data['content'];
            }
            $historyCheckPoint->save();
            $message=[
                'status' => true,
                'message' => 'Thêm mới thành công',
                'data' => $historyCheckPoint
            ];
        } else {
            $dataCheckPoint = $this->update($check_history->id, $data);
            $message= [
                'status' => true,
                'message' => 'Cập nhật thành công',
                'data' => $dataCheckPoint,
            ];
        }
        return  $message;
    }
    public function getAllHistory($param)
    {
        $dataHistoryCheckPoint = HistoryCheckPoint::where('check_point_id',$param['check_point_id'])
        ->leftjoin('users','users.id','history_check_point.user_id')
        ->leftjoin('master_type_status_assess','master_type_status_assess.id','history_check_point.status')
        ->select('history_check_point.*','users.name','users.joined_date','master_type_status_assess.name_type_assess as status_name');
        // ->where('user_id',$data['user_id']);
        if(isset($param['username'])) 
        {
            $dataHistoryCheckPoint->where('users.name','like' , '%'.$param['username'].'%');
        }
        $dataHistoryCheckPoint = $dataHistoryCheckPoint->paginate(isset($param['pageSize']) ? $param['pageSize'] : 15);
        return [
            'status' => true,
            'message' => 'Lấy danh sách thành công',
            'data' => $dataHistoryCheckPoint->items(),
            'pages'=>[
                'totalElements'      =>$dataHistoryCheckPoint->total(),
                'numberItemPerPage'    =>$dataHistoryCheckPoint->perPage(),
                'currentPage'=>$dataHistoryCheckPoint->currentPage()
            ]
        ];
    }
    public function detailHistosyCheckPoint($id)
    {
        if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2){
            $detailHistosyCheckPoint = HistoryCheckPoint::where('history_check_point.id',$id)
            ->leftjoin('master_type_status_assess as master_assess_user','master_assess_user.id','history_check_point.status')
            ->join('check_point','check_point.id','history_check_point.check_point_id')
            ->leftjoin('users','users.id','history_check_point.user_id')
            ->select('history_check_point.*','master_assess_user.name_type_assess as status_name','check_point.name_assess','users.name','users.email','users.joined_date','users.number_years_experience','check_point.start_date','check_point.end_date','check_point.status as status_checkpoint')
            ->first();
        } else {
            $detailHistosyCheckPoint = HistoryCheckPoint::where('check_point_id',$id)
            ->where('user_id',Auth::user()->id)
            ->leftjoin('master_type_status_assess as master_assess_user','master_assess_user.id','history_check_point.status')
            ->join('check_point','check_point.id','history_check_point.check_point_id')
            ->leftjoin('users','users.id','history_check_point.user_id')
            ->select('history_check_point.*','master_assess_user.name_type_assess as status_name','check_point.name_assess','users.name','users.email','users.joined_date','users.number_years_experience','check_point.start_date','check_point.end_date','check_point.status as status_checkpoint')
            ->first();
        }
        if($detailHistosyCheckPoint) {
            $checkContract = Contract::where('user_id',$detailHistosyCheckPoint->user_id)
            ->orderBy('created_at', 'desc')
            ->first();
            
            if ($detailHistosyCheckPoint->current_salary) {
                $detailHistosyCheckPoint->current_salary = $detailHistosyCheckPoint->current_salary;
            } else {
                $detailHistosyCheckPoint->current_salary = $checkContract ? $checkContract->salary : null;
            }
            $newKill = Kills::where('check_point_id',$detailHistosyCheckPoint->check_point_id)
            ->where('user_id',$detailHistosyCheckPoint->user_id)->get();
            $achievement_work = AchievementWork::where('check_point_id',$detailHistosyCheckPoint->check_point_id)
            ->where('user_id',$detailHistosyCheckPoint->user_id)->get();
            $detailHistosyCheckPoint['data_skill'] = $newKill;
            $detailHistosyCheckPoint['data_achievement_work'] = $achievement_work;
        }
        // if( !$detailHistosyCheckPoint && Auth::user()->role_id != 1) {
        //     $checkHistoryPoint = HistoryCheckPoint::
        //     where('user_id',Auth::user()->id)
        //     ->orderBy('created_at', 'desc')
        //     ->first();
        //     $checkContract = Contract::where('user_id',Auth::user()->id)
        //     ->orderBy('created_at', 'desc')
        //     ->first();
        //     $CheckPoint = CheckPoint::find($id);
        //     $detailHistosyCheckPoint = [
        //         'user_id' => Auth::user()->id,
        //         'target_previous_period' => $checkHistoryPoint ? $checkHistoryPoint->target_previous_period : null,
        //         'name' => Auth::user()->name,
        //         'email' => Auth::user()->email,
        //         'joined_date' => Auth::user()->joined_date,
        //         'number_years_experience' => Auth::user()->number_years_experience,
        //         'start_date' => $CheckPoint ? $CheckPoint->start_date :'',
        //         'end_date' => $CheckPoint ? $CheckPoint->end_date :'',
        //         'data_skill' => [],
        //         'data_achievement_work' =>[],
        //         'status'=> null,
        //         'new_salary'=> null,
        //         'target_next_period' =>null,
        //         'development_expectations' =>null,
        //         'content' =>null,
        //         'name_assess' => $CheckPoint ? $CheckPoint->name_assess :'',
        //         'status_checkpoint' => $CheckPoint ? $CheckPoint->status : '' 
        //     ];
        //      if ($checkHistoryPoint) {
        //         $detailHistosyCheckPoint['current_salary'] = $checkHistoryPoint->current_salary;
        //     } else {
        //         $detailHistosyCheckPoint['current_salary'] = $checkContract ? $checkContract->salary : null;
        //     }
        // }   
        $message = [
            'status' => true,
            'message' => 'Lấy dữ liệu thành công',
            'data' =>$detailHistosyCheckPoint,
        ];
        return  $message;
    }
    public function sumUserCheckPoint($id)
    {
        $countUserCheckPoint = CheckPoint::find($id);
        $numberUserRated = HistoryCheckPoint::where('check_point_id',$id)->whereIn('status', [4, 5])->count();
        $numberUserNotSubmit = HistoryCheckPoint::where('check_point_id',$id)->whereIn('status', [2])->count();
        $Count = [
            "numberUserRated" => $numberUserRated,
            "numberUserNotSubmit" =>$numberUserNotSubmit,
            "numberUserNotRated" => $countUserCheckPoint->number_staff - $numberUserRated - $numberUserNotSubmit
        ];
        return [
            'status' => true,
            'message' => 'Lấy danh sách thành công',
            'data' => $Count,
        ];
    }
    public function createHistoryCheckPoints($data)
    {
        try {
            DB::beginTransaction();
            $check_history = HistoryCheckPoint::where('check_point_id',$data['check_point_id'])
            ->where('user_id',$data['user_id'])->first();
            $check_history_user_point = HistoryCheckPoint::where('user_id',$data['user_id'])->orderBy('created_at', 'desc')->first();
            $check_point = Contract::where('user_id',$data['user_id'])
            ->orderBy('created_at', 'desc')->first();
            if (!$check_history) {
                $historyCheckPoint = new HistoryCheckPoint();
                $historyCheckPoint->check_point_id = $data['check_point_id'];
                $historyCheckPoint->user_id = $data['user_id'];
                $historyCheckPoint->status =  $data['status'];
                $historyCheckPoint->contract_id = $check_point ?  $check_point->id : 0;
                // if($check_history_user_point){
                //     $historyCheckPoint->current_salary = $check_history_user_point->new_salary ? $check_history_user_point->new_salary :  $check_history_user_point->current_salary;
                // } else if($check_point) {
                //     $historyCheckPoint->current_salary = $check_point->salary;
                // } else {
                //     $historyCheckPoint->current_salary = '';
                // }
                if (isset($data['current_salary'])) {
                    $historyCheckPoint->current_salary = $data['current_salary'];
                }
                if (isset($data['content'])) {
                    $historyCheckPoint->content = $data['content'];
                }
                if (isset($data['target_next_period'])) {
                    $historyCheckPoint->target_next_period = $data['target_next_period'];
                }
                if (isset($data['target_previous_period'])) {
                    $historyCheckPoint->target_previous_period = $data['target_previous_period'];
                }
                if($data['status'] == 2 || $data['status'] == 3 ){
                    $historyCheckPoint->save();
                    if(isset($data['data_skill']) && count($data['data_skill']) > 0) {
                        foreach ($data['data_skill'] as $key => $item){
                            $skill = new Kills();
                            $skill->check_point_id = $data['check_point_id'];
                            $skill->name_skill = $item['name_skill'];
                            $skill->level_id = $item['level_id'];
                            $skill->user_id = $historyCheckPoint->user_id;
                            $skill->type_skill_id = $item['type_skill_id'];
                            $skill->content= $item['content'];
                            $skill->save();
                        }
                    }
                    if(isset($data['data_achievement_work']) && count($data['data_achievement_work']) > 0) {
                        foreach ($data['data_achievement_work'] as $key => $item){
                            $achievementWork = new AchievementWork();
                            $achievementWork->check_point_id = $data['check_point_id'];
                            $achievementWork->project_id = $item['project_id'];
                            $achievementWork->user_id = $historyCheckPoint->user_id;
                            $achievementWork->participation_time = $item['participation_time'];
                            $achievementWork->work_name = $item['work_name'];
                            $achievementWork->result_user= $item['result_user'];
                            $achievementWork->result_leader= $item['result_leader'];
                            $achievementWork->comment= $item['comment'];
                            $achievementWork->save();
                        }
                    }
                    $message=[
                        'status' => true,
                        'message' => 'Thêm mới thành công',
                        'data' => $historyCheckPoint
                    ];
                } else {
                    $message=[
                        'status' => false,
                        'message' => 'Không có quyền thực hiện',
                    ];
                }
            } else {
                $user = Auth::user();
                if( $user->role_id == 1){
                    $message = $this->updateChekPoint($check_history->id, $data);
       
                } else {
                    if(($data['status'] == 4 || $data['status'] == 5)){
                        $message=[
                            'status' => false,
                            'message' => 'Không có quyền thực hiện',
                        ];
                    } else {
                        $message = $this->updateChekPoint($check_history->id, $data);
                    }
                    
                }
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            dd($e);
        }
        return  $message;
    }
    public function updateChekPoint($id, $data){
        $check_point = Contract::where('user_id',$data['user_id'])
            ->orderBy('created_at', 'desc')->first();
        $data['contract_id'] =  $check_point->id;
       
        $updateKill = CheckPoint::find($data['check_point_id']);
        if(count($data['data_skill']) > 0){
            foreach ($data['data_skill'] as $key => $value) {
                if($value){
                    $dataKillUpdate[$value['name_skill']] = [
                        'name_skill' => $value['name_skill'],
                        'level_id' => $value['level_id'],
                        'type_skill_id' => $value['type_skill_id'],
                        'content' => $value['content'],
                        'user_id' => $data['user_id'],
                    ];
                }
            }
            $updateKill->newKillUserCheckPoin()->sync($dataKillUpdate);
        } else {
            Kills::where('check_point_id',$data['check_point_id'])->where('user_id',$data['user_id'])->delete(); 
        }
        $average = 0;
        if(count($data['data_achievement_work']) > 0){
            foreach ($data['data_achievement_work'] as $key => $value) {
                $average = $average + $value['result_leader'];
                if($value){
                    $dataAchievementWorkUpdate[$value['project_id']] = [
                        'user_id' => $data['user_id'],
                        'participation_time' => $value['participation_time'],
                        'work_name' => $value['work_name'],
                        'result_user' => $value['result_user'],
                        'result_leader' => $value['result_leader'],
                        'comment' => $value['comment'],
                    ];
                }
            }
            $updateKill->achievementWorks()->sync($dataAchievementWorkUpdate);
            if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2) {
                $data['point_average'] =  $average /count($data['data_achievement_work']) ;
            }
        } else {
            $data['point_average'] =  null ;
            AchievementWork::where('check_point_id',$data['check_point_id'])->where('user_id',$data['user_id'])->delete();
        }
        
       
        $dataCheckPoint = $this->update($id, $data);
        return [
            'status' => true,
            'message' => 'Cập nhật thành công',
            'data' => $dataCheckPoint,
        ];
    }
}
