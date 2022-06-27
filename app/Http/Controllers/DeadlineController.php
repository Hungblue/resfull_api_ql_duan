<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeadlineRequest;
use App\Repositories\DeadlineRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
class DeadlineController extends Controller
{
   protected $deadlineRepository;

   public function __construct(DeadlineRepository $deadlineRepository)
   {
       $this->deadlineRepository = $deadlineRepository;
   }

   public function store(DeadlineRequest $request)
   {
      if (Auth::user()->role_id == 1 || Auth::user()->role_id == 2) {
        $deadline = DB::transaction(function () use ($request){
          return $this->deadlineRepository->create($request->all());
        });
       return response()->json([
           'status' => true,
           'message' => 'Tạo thành công',
           'data' => $deadline
       ])->setStatusCode(200);
      }else{
        return response()->json([
            'status' => false,
            'message' => 'Bạn không có quyền truy cập vào chức năng này',
        ])->setStatusCode(400);
      }
   }

   public function getAll()
   {
      if (Auth::user()->role_id == 1 || Auth::user()->role_id == 2) {
        $deadline = $this->deadlineRepository->getAllDeadlines();
        return $deadline ?
            response()->json([
                'status' => true,
                'message' => 'Lấy dữ liệu thành công',
                'data' => $deadline
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

   public function getDetail(Request $request)
   {
      if (Auth::user()->role_id == 1 || Auth::user()->role_id == 2) {
        $deadline = $this->deadlineRepository->find($request->id);
        return $deadline ?
            response()->json([
                'status' => true,
                'message' => 'Lấy dữ liệu thành công',
                'data' => $deadline
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
        $deadline = DB::transaction(function () use ($request){
          return  $this->deadlineRepository->update($request->id, $request->all());
        });
        return response()->json([
            'status' => true,
            'message' => 'Sửa thành công',
            'data' => $deadline
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
        $deadline = DB::transaction(function () use ($request){
            return $this->deadlineRepository->delete($request->id);
        });
        return $deadline ?
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
