<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\PositionRepository;

class PositionController extends Controller
{
    protected $positionRepository;
    public function __construct(PositionRepository $positionRepository)
    {
        $this->positionRepository = $positionRepository;
    }
    public function getAll(Request $request)
    {
        $listPosition = $this->positionRepository->getAll(); 
        return response()->json([
            'status' => true,
            'message' => 'Lấy danh sách thành công',
            'data' => $listPosition
        ])->setStatusCode(200);
    }
}
