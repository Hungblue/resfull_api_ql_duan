<?php

namespace App\Http\Controllers;

use App\Repositories\ProjectRepository;
use Illuminate\Http\Request;
use App\Http\Requests\ProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class ProjectController extends Controller
{
    protected $projectRepository;
    public function __construct(ProjectRepository $projectRepository)
    {
        $this->projectRepository = $projectRepository;
    }
    //
    public function getAll()
    {
        $projects = $this->projectRepository->getList();
        return response()->json([
            'status' => true,
            'message' => 'Lấy danh sách dự án thành công',
            'data' => $projects
        ])->setStatusCode(200);
    }

    public function getDetailProject(Request $request)
    {
        $project = $this->projectRepository->find($request->id);
        $listUser=$project->listUserResources;
        if ($project->leader_id == Auth::id() || Auth::user()->role_id != 4|| count($listUser)>0) {
            $project = $this->projectRepository->getDetailProject($request->id);
            return $project != null ?
                response()->json([
                    'status' => true,
                    'message' => 'Lấy chi tiết dự án thành công',
                    'data' => $project
                ])->setStatusCode(200) :
                response()->json([
                    'status' => false,
                    'message' => 'Dự án không tồn tại',
                    'data' => ''
                ])->setStatusCode(200);
        } else {
            return response()->json([
                'status' => true,
                'message' => 'Bạn không có quyền truy cập dự án này',
                'data' => ''
            ])->setStatusCode(200);
        }
    }

    public function store(ProjectRequest $request)
    {
        $project = DB::transaction(function () use ($request) {
            if ($request->hasFile('avatar')) {
                $imageName = 'image_' . time() . rand(0, 10000) . '.' . $request->file('avatar')->getClientOriginalExtension();
                $data = $request->all();
                $baseUrl = URL::to('/');
                $data['leader_id']=Auth::id();
                $data['avatar'] = $baseUrl . 'images/' . $imageName;
                $project = $this->projectRepository->create($data);
                $request->file('avatar')->move(public_path() . '/images', $imageName);
                return $project;
            } else {
                $data = $request->all();
                $data['leader_id']=Auth::id();
                $project = $this->projectRepository->create($data);
                return $project;
            }
        });
        return response()->json([
            'status' => true,
            'message' => 'Tạo dự án thành công',
            'data' => $project
        ], 200);
    }

    public function update(Request $request)
    {
        if (!$this->checkUser($request->id)) {
            return response()->json([
                'status' => false,
                'message' => 'Bạn không có quyền thao tác với dự án này',
                'data' => ''
            ])->setStatusCode(200);
        } else {
            $project = DB::transaction(function () use ($request) {
                return $this->projectRepository->update($request->id, $request->all());
            });
            return $project != null ?
                response()->json([
                    'status' => true,
                    'message' => 'Sửa dự án thành công',
                    'data' => $project
                ])->setStatusCode(200) :
                response()->json([
                    'status' => false,
                    'message' => 'Dự án không tồn tại',
                    'data' => ''
                ])->setStatusCode(200);
        }
    }

    public function delete(Request $request)
    {
        if (!$this->checkUser($request->id)) {
            return response()->json([
                'status' => false,
                'message' => 'Bạn không có quyền thao tác với dự án này',
                'data' => ''
            ])->setStatusCode(200);
        } else {
            $project = DB::transaction(function () use ($request) {
                return $this->projectRepository->delete($request->id);
            });
            return $project ?
                response()->json([
                    'status' => true,
                    'message' => 'Xóa dự án thành công',
                ], 200) :
                response()->json([
                    'status' => false,
                    'message' => 'Dự án không tồn tại',
                ], 200);
        }
    }

    public function checkUser($id)
    {
        $project = $this->projectRepository->find($id);
        if ($project->leader_id == Auth::id() || Auth::user()->username == 'admin' || Auth::user()->role_id == 1) {
            return true;
        } else
            return false;
    }
}
