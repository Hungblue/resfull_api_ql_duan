<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\Contract;
use App\Repositories\Repository;
use DB,Auth;
class ContractRepository extends Repository
{

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return Contract::class;
    }
    public function getAllContract($data)
    {
        if(Auth::user()->role_id == 1 || Auth::user()->role_id == 2){
            $listContract = User::join('contract','users.id','contract.user_id')
            ->select(DB::raw('contract.user_id, users.name,users.joined_date,users.number_years_experience, contract.start_date, contract.salary'))
            ->distinct('contract.user_id');
        } else {
            $listContract = User::join('contract','users.id','contract.user_id')
            ->select(DB::raw('contract.user_id, users.name,users.joined_date,users.number_years_experience, contract.start_date, contract.salary'))
            ->where('users.id',Auth::user()->id)
            ->distinct('contract.user_id');
        }   
        if (isset($data['username']) && $data['username'] != "") {
			$listContract->where( 'users.name','LIKE','%' . $data['username'] . '%');
		}
        if (isset($data['typecontract']) && $data['typecontract'] != "" && $data['typecontract'] != null) {
			$listContract->where( 'contract.type_contract',$data['typecontract']);
		}
        $listContract = $listContract->get();
        $idContract = [];
        foreach ($listContract as $key => $value) {
           $detailContract = $this->checkContract($value->user_id);
           if(isset($data['typecontract']) && $detailContract  && $detailContract->type_contract == $data['typecontract']){
                array_push($idContract ,$detailContract->id);
           } 
           if ((isset($data['typecontract']) == false || $data['typecontract'] == "" || $data['typecontract'] == null) && $detailContract ) {
                array_push($idContract ,$detailContract->id);
           }
        }
        $dataContract = Contract::join('users','users.id','contract.user_id')
            ->join('contract_type','contract_type.id','contract.type_contract')
            ->select(DB::raw('contract.id,contract.user_id, users.name,users.joined_date,users.number_years_experience,contract_type.contract_name, contract.start_date, contract.salary'))
            ->whereIn('contract.id',$idContract);
        if (isset($data['pageSize'])) {
			$dataContract = $dataContract->paginate($data['pageSize']);
		}
        return [
            'status' => true,
            'message' => 'Lấy danh sách thành công',
            'data' => $dataContract->items(),
            'pages'=>[
                    'totalElements'      =>$dataContract->total(),
                    'numberItemPerPage'    =>$dataContract->perPage(),
                    'currentPage'=>$dataContract->currentPage()
                ]
            ];
    }
    public function checkContract($id)
    {
        $dataDetailContrac = Contract::join('contract_type','contract_type.id','contract.type_contract')
        ->select('contract.*','contract_type.contract_name')
        ->where('contract.user_id',$id) 
        ->orderBy('contract.created_at', 'desc')->first();
        return $dataDetailContrac;
    }

    public function detailContract($id)
    {
        $dataDetailContrac = Contract::find($id);
        return $dataDetailContrac;
    }

    public function historyContract($id)
    {
        $dataHistoryContrac = Contract::select('contract.id','contract.start_date','contract.end_date','contract.salary','contract_type.contract_name','users.name')
        ->join('contract_type','contract_type.id','contract.type_contract')
        ->join('users','users.id','contract.user_id')
        ->where('contract.user_id',$id) 
        ->orderBy('contract.created_at', 'desc')
        ->get();
        return $dataHistoryContrac;
    }
    public function updateContract($id,$param)
    {
        $idContract = $this->find($id);
        if ($idContract) {
            $idContract->update($param);
           
        }
        return $idContract;
    }
}
