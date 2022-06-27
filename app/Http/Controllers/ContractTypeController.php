<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ContractTypeRepository;

class ContractTypeController extends Controller
{
    protected $contractTypeRepository;
    public function __construct(ContractTypeRepository $contractTypeRepository)
    {
        $this->contractTypeRepository = $contractTypeRepository;
    }
    public function getAll(Request $request)
    {
        $listContractType = $this->contractTypeRepository->getAll(); 
        return response()->json([
            'status' => true,
            'message' => 'Lấy danh sách thành công',
            'data' => $listContractType
        ])->setStatusCode(200);
    }
}
