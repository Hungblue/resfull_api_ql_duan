<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\AllowanceRepository;

class AllowanceController extends Controller
{
    protected $allowanceRepository;
    public function __construct(AllowanceRepository $allowanceRepository)
    {
        $this->allowanceRepository = $allowanceRepository;
    }
    public function getAll(Request $request)
    {
        $listAllowance = $this->allowanceRepository->getAll(); 
        return response()->json([
            'status' => true,
            'message' => 'Lấy danh sách thành công',
            'data' => $listAllowance
        ])->setStatusCode(200);
    }
}
