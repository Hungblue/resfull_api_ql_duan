<?php

namespace App\Repositories;

use App\Repositories\Repository;
use App\Models\CheckPoint;
use App\Models\User;
use Auth,DB;
use App\Models\HistoryCheckPoint;
use App\Models\Contract;

class CheckPointRepository extends Repository
{

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return CheckPoint::class;
    }
    public function createCheckPoint($data)
    {
        try {
            DB::beginTransaction();
            $check_assess = CheckPoint::where("end_date", '>=',date('Y-m-d')) ->orderBy('created_at', 'desc')->first();
            $today= date('Y-m-d');
        
            $checkPoint = CheckPoint::where('end_date','<', $today)->where('status','<>',5)->get();
            foreach ($checkPoint as $item) {
                $updateCheckPoint = CheckPoint::find($item->id);
                $updateCheckPoint->status = 5;
                $updateCheckPoint->save();
            }

            if(!$check_assess){
                $numberUser = User::where('status','<>',4)->count();

                $check_point = new CheckPoint();
                $check_point->name_assess = $data['name_assess'];
                $check_point->start_date = $data['start_date'];
                $check_point->end_date = $data['end_date'];
                $check_point->number_staff = $numberUser;
                if($today <  $data['end_date']){
                    $check_point->status = 1;
                } else {
                    $check_point->status = 5;
                }
                
                if (isset($data['content'])) {
                    $check_point->content = $data['content'];
                }
                $check_point->save();

                $listUser = User::where('status','<>',4)->get();
                foreach ($listUser as $key => $value) {
                    $check_contract = Contract::where('user_id',$value->id)
                    ->orderBy('created_at', 'desc')->first();
                    $check_history_user_point = HistoryCheckPoint::where('user_id',$value->id)
                    ->orderBy('created_at', 'desc')->first();

                    $historyCheckPoint = new HistoryCheckPoint();
                    $historyCheckPoint->check_point_id = $check_point->id;
                    $historyCheckPoint->user_id = $value->id;
                    $historyCheckPoint->status =  2;
                    $historyCheckPoint->contract_id = $check_contract ?  $check_contract->id : 0;
                    if ($check_history_user_point){
                        $historyCheckPoint->current_salary = $check_history_user_point->new_salary ? $check_history_user_point->new_salary :  $check_history_user_point->current_salary;
                    } else {
                        $historyCheckPoint->current_salary = $check_contract ? $check_contract->salary : null;
                    }
                    $historyCheckPoint->target_previous_period = $check_history_user_point ? $check_history_user_point->target_previous_period : null;
                    $historyCheckPoint->save();
                }
                
                $message=[
                    'status' => true,
                    'message' => 'Thêm mới thành công',
                    'data' => $check_point
                ];
            } else {
                $message=[
                    'status' => false,
                    'message' => 'kỳ đánh giá trước chưa kết thức',
                ];
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            dd($e);
        }
        return  $message;
    }
    public function getAllCheckPoint($param)
    {
        if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2){
            $listCheckPoint = CheckPoint::
            leftjoin('master_type_status_assess as master_assess','master_assess.id','check_point.status')
            ->select('check_point.*','master_assess.name_type_assess as status_name') 
            ->orderBy('check_point.end_date', 'desc');
        } else {
            $listCheckPoint = CheckPoint::
            leftjoin('history_check_point','check_point.id','history_check_point.check_point_id')
            ->leftjoin('master_type_status_assess as master_assess','master_assess.id','check_point.status')
            ->leftjoin('master_type_status_assess as master_assess_user','master_assess_user.id','history_check_point.status')
            ->select('check_point.*','master_assess.name_type_assess as status_name',
            'history_check_point.status as status_history_check_point_id',
            'master_assess_user.name_type_assess as status_name_history_point',
            'history_check_point.current_salary','history_check_point.current_salary',
            'history_check_point.point_average'
            ) 
            ->orderBy('check_point.end_date', 'desc')
            ->where('history_check_point.user_id',Auth::user()->id)
            ;
        
        }
        
        if(isset($param['name_check_point'])) 
        {
            $listCheckPoint->where('check_point.name_assess','like' , '%'.$param['name_check_point'].'%');
        }
        $listCheckPoint = $listCheckPoint->paginate(isset($param['pageSize']) ? $param['pageSize'] : 15);
        // $dataCheckPointUser = [];
        // if(Auth::user()->role_id != 1){
        //     foreach($listCheckPoint as $history ) {
        //         $this->check_history($history);
        //         array_push($dataCheckPointUser, $history);
        //     }
        // }
        return [
            'status' => true,
            'message' => 'Lấy danh sách thành công',
            'data' => $listCheckPoint->items(),
            'pages'=>[
                'totalElements'      =>$listCheckPoint->total(),
                'numberItemPerPage'    =>$listCheckPoint->perPage(),
                'currentPage'=>$listCheckPoint->currentPage()
            ]
        ];
    }
    public function check_history($data) {
        $listCheckPoint = HistoryCheckPoint::
        where('user_id',Auth::user()->id)
        ->select('history_check_point.*','master_type_status_assess.name_type_assess' )
        ->leftjoin('master_type_status_assess','master_type_status_assess.id','history_check_point.status')
        ->where('check_point_id',$data['id'])
        ->orderBy('created_at', 'desc')
        ->first();
        $checkContract = Contract::where('user_id',Auth::user()->id)
        ->orderBy('created_at', 'desc')
        ->first();
        $checkHistoryCheckPoint = HistoryCheckPoint::
        where('user_id',Auth::user()->id)
        ->orderBy('created_at', 'desc')
        ->first();
        if ($listCheckPoint) {
            $data->current_salary = $listCheckPoint->current_salary;
            $data->point_average = $listCheckPoint->point_average ? $listCheckPoint->point_average : null;
        } else if ($checkHistoryCheckPoint) {
            $data->current_salary = $checkHistoryCheckPoint->current_salary;
        } else {
            $data->current_salary = $checkContract ? $checkContract->salary : null;
           
        }
        if ($listCheckPoint) {
            $data->status_name_history_point = $listCheckPoint->name_type_assess;
            $data->status_history_check_point_id =  $listCheckPoint->status ;
        } else {
            $data->status_name_history_point = 'Đang mở';
            $data->status_history_check_point_id = 1;
        }
    }
    public function updateCheckPoint($id,$data)
    {
        $today= date('Y-m-d');
        if ($data['end_date'] < $today) {
            $data['status'] = 5;
        } else {
            $data['status'] = 1;
        }
        $dataCheckPoint = $this->update($id, $data);
        return [
            'status' => true,
            'message' => 'Cập nhật thành công',
            'data' => $dataCheckPoint,
        ];
    }
}
