<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\CheckPointRepository;
use App\Http\Requests\CheckPointRequest;

class CheckPointController extends Controller
{
    protected $checkPointRepository;

    public function __construct(CheckPointRepository $checkPointRepository)
    {
        $this->checkPointRepository = $checkPointRepository;
    }

    public function createCheckPoint(CheckPointRequest $request){
        $checkPoint =  $this->checkPointRepository->createCheckPoint($request->all());
        return response()->json($checkPoint)->setStatusCode($checkPoint['status'] ? 200 : 400);
    }
    public function getAll(Request $request)
    {
        $checkPoint =  $this->checkPointRepository->getAllCheckPoint($request->all()); 
        return response()->json($checkPoint)->setStatusCode(200);
    }
    public function updateCheckPoint($id ,Request $request)
    {
        $checkPoint =  $this->checkPointRepository->updateCheckPoint($id,$request->all()); 
        return response()->json($checkPoint)->setStatusCode($checkPoint['status'] ? 200 : 400);
    }
    public function delete($id)
    {
        $deletePoint =  $this->checkPointRepository->delete($id); 
        if($deletePoint){
            $message= [
                'status' => $deletePoint,
                'message' => 'Xóa thành công',
            ];
        } else {
            $message= [
                'status' => $deletePoint,
                'message' => 'Dữ liệu không tồn tại',
            ];
        }
        return response()->json($message)->setStatusCode($deletePoint ? 200 : 400);
    }
    public function detailCheckPoint($id)
    {
        $detailPoint =  $this->checkPointRepository->find($id); 
        if($detailPoint){
            $message= [
                'status' => true,
                'message' => 'Lấy dữ liệu thành công',
                'data' =>$detailPoint,
            ];
        } else {
            $message= [
                'status' => false,
                'message' => 'Dữ liệu không tồn tại',
            ];
        }
        return response()->json($message)->setStatusCode($detailPoint ? 200 : 400);
    }
}
