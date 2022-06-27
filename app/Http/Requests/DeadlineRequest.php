<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class DeadlineRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'project_id' => 'required',
            'name' => 'required',
            'date' => 'required',
            'status' => 'required',

        ];
    }

    public function messages()
    {
        return [
            'project_id.required' => 'Không xác định dự án',
            'name.required' => 'Nội dung không được để trống',
            'date.required' => 'Ngày không được để trống',
            'status.required' => 'Status không được để trống',

        ];
    }
}
