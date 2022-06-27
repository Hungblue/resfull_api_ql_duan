<?php

namespace App\Http\Requests;
use App\Http\Requests\BaseRequest;
use Illuminate\Support\Facades\Auth;

class ProjectRequest extends BaseRequest
{

    public function authorize()
    {
        return Auth::check();
    }

    public function rules()
    {
        return [
            'name' => 'required|unique:projects',
            'avatar' => 'mimes:jpeg,jpg,png|max:5120',
            'start_date' => 'required',
            'plan_close_date' => 'required',
            'contract_status' => 'required',
            'type' => 'required',

        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Tên dự án không được để trống',
            'name.unique' => 'Dự án đã tồn tại',
            'avatar.mimes' => 'Định dạng không hợp lệ',
            'avatar.max' => 'Quá dung lượng cho phép',
            'start_date.required' => 'Ngày bắt đầu không được để trống',
            'plan_close_date.required' => 'Ngày dự kiến kết thúc không được để trống',
            'contract_status.required' => 'Trạng thái hợp đồng không được để trống',
            'type.required' => 'Loại dự án không được để trống',

        ];
    }
}
