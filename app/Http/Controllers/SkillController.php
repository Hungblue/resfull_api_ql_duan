<?php

namespace App\Http\Controllers;

use App\Models\UserSkill;
use App\Repositories\SkillRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SkillController extends Controller
{
    protected $SkillRepository;
    public function __construct(SkillRepository $SkillRepository)
    {
        $this->SkillRepository = $SkillRepository;
    }
    //
    public function getAll()
    {
        $skills = $this->SkillRepository->getAllSkill();
        return response()->json([
            'status' => true,
            'message' => 'Lấy skill thành công',
            'data' => $skills
        ])->setStatusCode(200);
    }
    //delete
    public function delete(Request $request)
    {
        $skills = DB::transaction(function () use ($request) {
            return $this->SkillRepository->delete($request->id);
        });
        return $skills ?
            response()->json([
                'status' => true,
                'message' => 'Xóa skill thành công',
            ], 200) :
            response()->json([
                'status' => false,
                'message' => 'Không tồn tại',
            ], 200);
    }
    public function getSkill(Request $request)
    {
        $getSkill = $this->SkillRepository->getSkill($request->id);
        return $getSkill ?
            response()->json([
                'status' => true,
                'message' => 'Lấy chi tiết skill thành cồng',
                'data' => $getSkill
            ], 200) :
            response()->json([
                'status' => false,
                'message' => 'Không tồn tại',
            ], 200);
    }
}
