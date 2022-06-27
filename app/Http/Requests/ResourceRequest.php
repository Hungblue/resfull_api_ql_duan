<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ResourceRequest extends BaseRequest
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
            'user_id' => 'required',
            'busy_rate' => 'required',
            'status' => 'required',

        ];
    }

    public function messages()
    {
        return [
            'project_id.required' => 'Không tìm thấy dự án',
            'user_id.required' => 'Vui lòng chọn user',
            'busy_rate.required' => 'Lượng thời gian không được để trống',
            'status.required' => 'Status không được để trống',

        ];
    }
}
