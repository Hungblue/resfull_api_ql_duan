<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmailRemindRequest;
use App\Models\EmailRemind;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Repositories\EmailRemindRepository;

class EmailRemindController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(EmailRemindRepository $EmailRemindRepository)
    {
        $this->EmailRemindRepository = $EmailRemindRepository;
    }
    public function getAll()
    {
        $getAll = $this->EmailRemindRepository->getAll();
        return response()->json([
            'status' => true,
            'message' => 'Lấy dữ liệu thành công',
            'data' => $getAll
        ])->setStatusCode(200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(EmailRemindRequest $request)
    {

        $email = DB::transaction(function () use ($request) {
            return $this->EmailRemindRepository->create($request->all());
        });
        return response()->json([
            'status' => true,
            'message' => 'Tạo thành công',
            'data' => $email
        ])->setStatusCode(200);
    }
    public function delete($id)
    {
        $deleteEmail = $this->EmailRemindRepository->delete($id);
        return response()->json([
            'status' => true,
            'message' => 'Tạo thành công',
        ])->setStatusCode(200);
    }
    public function update($id, EmailRemindRequest $request)
    {
        $email = DB::transaction(function () use ($request) {
            return $this->EmailRemindRepository->update($request->id, $request->all());
        });
        return  response()->json([
                'status' => true,
                'message' => 'Cập nhật thành công',
                'data' => $email
            ])->setStatusCode(200);
    }
}
