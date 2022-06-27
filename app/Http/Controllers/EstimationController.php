<?php

namespace App\Http\Controllers;

use App\Http\Requests\EstimationRequest;
use App\Repositories\EstimationRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
class EstimationController extends Controller
{
    protected $estimationRepository;
    public function __construct(EstimationRepository $estimationRepository)
    {
        $this->estimationRepository = $estimationRepository;
    }

    public function store(EstimationRequest $request)
    {
        if (Auth::user()->role_id == 1 || Auth::user()->role_id == 2) {
        $estimation = DB::transaction(function () use ($request) {
            return $this->estimationRepository->create($request->all());
        });
        return response()->json([
            'status' => true,
            'message' => 'Tạo estimation thành công',
            'data' => $estimation
        ], 200);
        }else{
            return response()->json([
                'status' => false,
                'message' => 'Bạn không có quyền truy cập vào chức năng này',
            ])->setStatusCode(400);
        }
    }

    public function getDetail(Request $request)
    {
        if (Auth::user()->role_id != 4) {
        $estimation = $this->estimationRepository->find($request->id);
        return $estimation ?
            response()->json([
                'status' => true,
                'message' => 'Lấy dữ liệu thành công',
                'data' => $estimation
            ], 200) :
            response()->json([
                'status' => false,
                'message' => 'Lấy dữ liệu thất bại',
            ], 200);
        }else{
            return response()->json([
                'status' => false,
                'message' => 'Bạn không có quyền truy cập vào chức năng này',
            ])->setStatusCode(400);
        }
    }

    public function update(Request $request)
    {
        if (Auth::user()->role_id == 1 || Auth::user()->role_id == 2) {
        $estimation = DB::transaction(function () use ($request) {
            return $this->estimationRepository->update($request->id, $request->all());
        });
        return response()->json([
            'status' => true,
            'message' => 'Sửa thành công',
            'data' => $estimation
        ], 200);
        }else{
            return response()->json([
                'status' => false,
                'message' => 'Bạn không có quyền truy cập vào chức năng này',
            ])->setStatusCode(400);
        }
    }

    public function delete(Request $request)
    {
        if (Auth::user()->role_id == 1 || Auth::user()->role_id == 2) {
        $estimation = DB::transaction(function () use ($request) {
            return $this->estimationRepository->delete($request->id);
        });
        return $estimation ?
            response()->json([
                'status' => true,
                'message' => 'Xóa thành công',
            ], 200) :
            response()->json([
                'status' => false,
                'message' => 'Xóa thất bại',
            ], 200);
        }else{
            return response()->json([
                'status' => false,
                'message' => 'Bạn không có quyền truy cập vào chức năng này',
            ])->setStatusCode(400);
        }
    }
}
