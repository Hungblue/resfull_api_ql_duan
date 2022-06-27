<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\AchievementWorkRepository;
use App\Http\Requests\AchievementWorkRequest;

class AchievementWorkController extends Controller
{
    protected $achievementWorkRepository;

    public function __construct(AchievementWorkRepository $achievementWorkRepository)
    {
        $this->achievementWorkRepository = $achievementWorkRepository;
    }
    public function create(AchievementWorkRequest $request)
    {
        $dataAchievementWork =  $this->achievementWorkRepository->create($request->all());
        return response()->json([
            'status' => true,
            'message' => 'Thêm mới thành công',
            'data' => $dataAchievementWork
        ])->setStatusCode(200);
    }
    public function update($id,AchievementWorkRequest $request)
    {
        $dataAchievementWork =  $this->achievementWorkRepository->update($id,$request->all());
        return response()->json([
            'status' => true,
            'message' => 'Cập nhật thành công',
            'data' => $dataAchievementWork
        ])->setStatusCode(200);
    }
    public function delete($id)
    {
        $deleteAchievementWork =  $this->achievementWorkRepository->delete($id);
        return response()->json([
            'status' => $deleteAchievementWork,
            'message' => 'Xóa thành công',
        ])->setStatusCode(200);
        
    }
    public function getAll(Request $request)
    {
        $listAchievementWork =  $this->achievementWorkRepository->getAllAchievementWork($request->all());
        return response()->json($listAchievementWork)->setStatusCode(200);
    }
    public function detail($id)
    {
        $detailAchievementWork =  $this->achievementWorkRepository->detailAchievementWork($id);
        return response()->json($detailAchievementWork)->setStatusCode(200);
    }
}
