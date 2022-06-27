<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\UserRequest;
use App\Models\EmailRemind;
use App\Models\User;
use App\Repositories\UserRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Auth;

class UserController extends Controller
{
    private $userRepository;
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    public function send_mail()
    {
        $today = date('Y-m-d');
    }
    public function getAll(Request $request)
    {

        if (Auth::user()->role_id != 4) {
            $users = $this->userRepository->getAllUsers($request->all());
            return response()->json([
                'status' => true,
                'message' => 'Lấy danh sách user thành công',
                'data' => $users
            ])->setStatusCode(200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Bạn không có quyền truy cập vào chức năng này',
            ])->setStatusCode(400);
        }
    }

    public function getAllSearchable(Request $request)
    {

        if (Auth::user()->role_id != 4) {
            $users = $this->userRepository->getAllSearchableUsers($request->all());
            return response()->json($users
            )->setStatusCode(200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Bạn không có quyền truy cập vào chức năng này',
            ])->setStatusCode(400);
        }
    }

    public function getUser(Request $request)
    {

        if (Auth::user()->id == $request->id || Auth::user()->role_id != 4) {
            $user = $this->userRepository->getUser($request->id);
            return $user ?
                response()->json([
                    'status' => true,
                    'message' => 'Lấy thông tin user thành công',
                    'data' => $user
                ], 200) :
                response()->json([
                    'status' => false,
                    'message' => 'Không tìm thấy user',
                ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Bạn không có quyền truy cập vào chức năng này',
            ])->setStatusCode(400);
        }
    }

    public function update(Request $request)
    {
        $data = $request->all();
        if (Auth::user()->role_id != 4) {
            $user = $this->userRepository->updates($request->id, $data);
            return response()->json([
                'status' => true,
                'message' => 'Sửa thành công',
                'data' => $user
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Bạn không có quyền truy cập vào chức năng này',
            ])->setStatusCode(400);
        }
    }

    public function delete(Request $request)
    {
        if (Auth::user()->role_id != 4) {
            $data = ['status' => 4];
            $user = $this->userRepository->update($request->id, $data);
            return $user ?
                response()->json([
                    'status' => true,
                    'message' => 'Xóa thành công',
                    'data' => $user,
                ], 200) :
                response()->json([
                    'status' => false,
                    'message' => 'Xóa thất bại',
                ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Bạn không có quyền truy cập vào chức năng này',
            ])->setStatusCode(400);
        }
    }

    public function adminResetPassword(Request $request) {
        if (Auth::user()->role_id != 1) {
            return response()->json([
                'status' => false,
                'message' => 'Bạn không có quyền truy cập vào chức năng này',
            ])->setStatusCode(400);
        }

        $user = $this->userRepository->adminResetPassword($request->all());
        return $user ?
                response()->json([
                    'status' => true,
                    'message' => 'Cài lại mật khẩu thành công',
                    'data' => $user,
                ], 200) :
                response()->json([
                    'status' => false,
                    'message' => 'Cài lại mật khẩu thất bại',
                ], 200);
    }
}
