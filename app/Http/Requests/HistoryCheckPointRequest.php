<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HistoryCheckPointRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'check_point_id' => 'required',
            'user_id' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'check_point_id.required' => 'Tên kỳ đánh giá không được để trống',
            'user_id.required' => 'tên user không để trống',
        ];
    }
}
