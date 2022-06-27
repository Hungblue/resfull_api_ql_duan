<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ContractRepository;
use App\Http\Requests\ContractRequest;

class ContractController extends Controller
{
    protected $contractRepository;
    public function __construct(ContractRepository $contractRepository)
    {
        $this->contractRepository = $contractRepository;
    }
    public function getAll(Request $request)
    {
        $listContract = $this->contractRepository->getAllContract($request->all()); 
        // return response()->json([
        //     'status' => true,
        //     'message' => 'Lấy danh sách thành công',
        //     'data' => $listContract
        // ])->setStatusCode(200);
        return response()->json($listContract)->setStatusCode(200);
    }
    public function createContract(ContractRequest $request)
    {
        // $this->contractRepository->createContract($request->all());
        $contract = $this->contractRepository->create($request->all()); 
        return response()->json([
            'status' => true,
            'message' => 'Thêm mới thành công',
            'data' => $contract
        ])->setStatusCode(200);
    }
    public function detailContract($id,Request $request){
        $listContract = $this->contractRepository->detailContract($id); 
        return response()->json([
            'status' => true,
            'message' => 'Lấy dữ liệu thành công',
            'data' => $listContract
        ])->setStatusCode(200);
    }
    public function historyContract($id)
    {
        $listContract = $this->contractRepository->historyContract($id); 
        return response()->json([
            'status' => true,
            'message' => 'Lấy dữ liệu thành công',
            'data' => $listContract
        ])->setStatusCode(200);
    }
    public function updateContract($id, Request $request)
    {
        $dataContract = $this->contractRepository->updateContract($id,$request->all()); 
        return response()->json([
            'status' => true,
            'message' => 'Cập nhật thành công',
            'data' => $dataContract
        ])->setStatusCode(200);
    }
}
