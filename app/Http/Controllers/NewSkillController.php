<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\NewSkillRepository;
use App\Http\Requests\NewSkillRequest;

class NewSkillController extends Controller
{
    protected $newSkillRepository;

    public function __construct(NewSkillRepository $newSkillRepository)
    {
        $this->newSkillRepository = $newSkillRepository;
    }
    public function createNewSkill(NewSkillRequest $request)
    {
        $dataKill =  $this->newSkillRepository->create($request->all());
        return response()->json([
            'status' => true,
            'message' => 'Thêm mới thành công',
            'data' => $dataKill
        ])->setStatusCode(200);
    }
    public function updateNewKill($id,NewSkillRequest $request)
    {
        $dataKill =  $this->newSkillRepository->update($id,$request->all());
        return response()->json([
            'status' => true,
            'message' => 'Cập nhật thành công',
            'data' => $dataKill
        ])->setStatusCode(200);
    }
    public function delete($id)
    {
        $deleteKill =  $this->newSkillRepository->delete($id);
        return response()->json([
            'status' => $deleteKill,
            'message' => 'Xóa thành công',
        ])->setStatusCode(200);
        
    }
    public function getAll(Request $request)
    {
        $listKill =  $this->newSkillRepository->getAllNewKill($request->all());
        return response()->json($listKill)->setStatusCode(200);
    }
    public function detailNewKill($id)
    {
        $detailKill =  $this->newSkillRepository->detailNewKill($id);
        return response()->json($detailKill)->setStatusCode(200);
    }
}