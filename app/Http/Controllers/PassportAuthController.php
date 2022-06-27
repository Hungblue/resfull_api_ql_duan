<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\UserSkill;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\loginProviderRequest;

class PassportAuthController extends Controller
{
    private $userRepository;
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function register(UserRequest $request)
    {

        $data = $request->all();
        $data['password'] = bcrypt($data['password']);
        $user = DB::transaction(function () use ($data) {
            return $this->userRepository->createSkill($data);
        });
        return response()->json([
            'status' => true,
            'message' => 'Thành công',
            'data' =>  $data,
        ])->setStatusCode(200);
    }

    public function login(Request $request)
    {
        $data = [
            'username' => $request->username,
            'password' => $request->password,
        ];
        $status=$this->userRepository->check($request->username);
        if (auth()->attempt($data) && $status->status !=4) {
            $token = auth()->user()->createToken('LaravelAuthApp')->accessToken;
            return response()->json([
                'status' => true,
                'message' => 'Đăng nhập thành công',
                'token' => $token,
                'data' => Auth::user()
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Đăng nhập thất bại',
                'error' => 'Unauthorised'
            ], 401);
        }
    }

    public function logout()
    {
        if (Auth::check()) {
            Auth::user()->AauthAcessToken()->delete();
        }
    }
    public function loginProvider(Request $request)
    {
        $user = $this->userRepository->loginProvider($request->all());
        return response()->json($user)->setStatusCode($user['Status'] ? 200 : 400);
    }

    public function changePassword(Request $request) {
        if (!isset( $request->password) ||  $request->password == "" ||
            !isset( $request->newPassword) ||  $request->newPassword == "") {
            return response()->json([
                'status' => false,
                'message' => 'Mật khẩu hiện tại hoặc mật khẩu mới không có hoặc để trống',
                'error' => 'Validated'
            ], 400);
        }

        $data = $request->all();
        // $data['password'] = bcrypt($data['password']);
        $status = $this->userRepository->changePassword($data);
        if ($status) {
            return response()->json([
                'status' => true,
                'message' => 'Đổi mật khẩu thành công',
            ], 200);
        }
        else {
            return response()->json([
                'status' => false,
                'message' => 'Đổi mật khẩu thất bại',
            ], 400);
        }

    }
}
