<?php

namespace App\Http\Controllers;

use App\Repositories\MasterRepository;
use Illuminate\Http\Request;

class MasterController extends Controller
{
    protected $masterRepository;

    public function __construct(MasterRepository $masterRepository)
    {
        $this->masterRepository = $masterRepository;
    }

    public function testApi() {
        return response()->json([
            'status' => true,
            'message' => "The API work normally.",
        ]);
    }

    public function getAll(Request $request)
    {
        try {
            if(strpos($request->table_name,"master_") >= 0){
                $master = $this->masterRepository->getAllMaster($request->table_name);
                $response = response()->json([
                    'status' => true,
                    'message' => "Lấy danh sách thành công",
                    'data' => $master
                ])->setStatusCode(200);
            }
        } catch (\Throwable $th) {
            //throw $th;
            $response = response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ]);
        }

        return $response;
    }

    public function getRoles(Request $request)
    {
        try {
            
            $master = $this->masterRepository->getRoles();
            $response = response()->json([
                'status' => true,
                'message' => "Lấy danh sách thành công",
                'data' => $master
            ])->setStatusCode(200);
        
        } catch (\Throwable $th) {
            //throw $th;
            $response = response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ]);
        }

        return $response;
    }
}
