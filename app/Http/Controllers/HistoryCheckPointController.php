<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\HistoryCheckPointRepository;
use App\Http\Requests\HistoryCheckPointRequest;

class HistoryCheckPointController extends Controller
{
    protected $historyCheckPointRepository;

    public function __construct(HistoryCheckPointRepository $historyCheckPointRepository)
    {
        $this->historyCheckPointRepository = $historyCheckPointRepository;
    }
    public function createHistoryCheckPoint(HistoryCheckPointRequest $request)
    {
        $checkPoint =  $this->historyCheckPointRepository->createHistoryCheckPoints($request->all());
        return response()->json($checkPoint)->setStatusCode(200);
    }
    public function getAll(Request $request)
    {
        $userHistosyCheckPoint =  $this->historyCheckPointRepository->getAllHistory($request->all());
        return response()->json($userHistosyCheckPoint)->setStatusCode(200);
    }
    public function detail($id)
    {
        $userHistosyCheckPoint =  $this->historyCheckPointRepository->detailHistosyCheckPoint($id);
        return response()->json($userHistosyCheckPoint)->setStatusCode(200);
    }
    public function delete($id)
    {
        $userHistosyCheckPoint =  $this->historyCheckPointRepository->delete($id);
        return response()->json([
            'status' => $userHistosyCheckPoint,
            'message' => 'Xóa thành công',
        ])->setStatusCode(200);
    }
    public function sumUserCheckPoint($id)
    {
        $countUser =  $this->historyCheckPointRepository->sumUserCheckPoint($id);
        return response()->json($countUser)->setStatusCode(200);
    }

}
