<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResourceRequest;
use App\Repositories\ResourceRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
class ResourceController extends Controller
{
    protected $resourceRepository;

    public function __construct(ResourceRepository $resourceRepository)
    {
        $this->resourceRepository = $resourceRepository;
    }

    public function store(ResourceRequest $request)
    {
        if (Auth::user()->role_id == 1 || Auth::user()->role_id == 2) {
        $resource = DB::transaction(function () use ($request){
            return $this->resourceRepository->create($request->all());
        });
        return response()->json([
            'status' => true,
            'message' => 'Thành công',
            'data' => $resource
        ])->setStatusCode(200);
        }else{
            return response()->json([
                'status' => false,
                'message' => 'Bạn không có quyền truy cập vào chức năng này',
            ])->setStatusCode(400);
        }
    }

    public function getDetail(Request $request)
    {
        $resource = $this->resourceRepository->find($request->id);
        return $resource ?
            response()->json([
                'status' => true,
                'message' => 'Lấy dữ liệu thành công',
                'data' => $resource
            ], 200) :
            response()->json([
                'status' => false,
                'message' => 'Lấy dữ liệu thất bại',
            ], 200);
    }

    public function update(Request $request)
    {
        if (Auth::user()->role_id == 1 || Auth::user()->role_id == 2) {
        $resource = DB::transaction(function () use ($request){
            return $this->resourceRepository->update($request->id, $request->all());
        });
        return response()->json([
            'status' => true,
            'message' => 'Sửa thành công',
            'data' => $resource
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
        $resource = DB::transaction(function () use ($request){
            return $this->resourceRepository->delete($request->id);
        });
        return $resource ?
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
